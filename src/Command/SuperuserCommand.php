<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\User;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleInputArgument;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Validation\Validator;
use Exception;
use Psr\Log\LogLevel;

/**
 * Superuser command.
 */
class SuperuserCommand extends Command
{
    protected string $name = 'superuser';

    protected ?string $defaultTable = 'Users';

    public static function defaultName(): string
    {
        return 'superuser';
    }

    public static function getDescription(): string
    {
        return 'Command description here.';
    }

    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->addArgument(new ConsoleInputArgument(
                name: 'subcommand',
                help: 'The subcommand to execute',
                required: true,
                choices: ['new', 'promote', 'demote', 'list'],
            ))
            ->addArgument(new ConsoleInputArgument(
                name: 'email',
                help: 'The email of the user to process',
                required: false,
            ))
            ->setDescription(static::getDescription());
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $subcommand = $args->getArgument('subcommand');
        $email = $args->getArgument('email');
        $this->log(__('Superuser command executed {0} {1}', $subcommand, $email ?? ''), LogLevel::NOTICE);

        if ($subcommand === 'new') {
            $this->createNewSuperuser($io, $email);
            return;
        }

        if ($subcommand === 'list') {
            $this->listUsers($io);
            return;
        }

        $this->modifyExistingUser($io, $subcommand, $email);
    }

    protected function listUsers(ConsoleIo $io)
    {
        $results = $this
            ->fetchTable()
            ->find()
            ->enableHydration(false)
            ->select(['email', 'is_superuser'])
            ->orderByDesc('is_superuser')
            ->orderByAsc('email')
            ->toArray();
        $io->helper('table')->output([['Email', 'Is Superuser']] + $results);
    }

    protected function handleValidationAndHasErrors(ConsoleIo $io, Validator $validator, array $data): bool
    {
        $errors = $validator->validate($data);
        foreach ($errors as $field => $message) {
            $io->error($message);
        }
        return count($errors) > 0;
    }

    protected function promptUser(ConsoleIo $io, string $for, Validator $validator): string
    {
        $value = $io->ask(__('Please enter {0}', $for));

        if ($this->handleValidationAndHasErrors($io, $validator, [$for => $value])) {
            return $this->promptUser($io, $for, $validator);
        }

        if ($io->ask(__('Confirm {0}', $for)) !== $value) {
            $io->warning(__('{0} does not match', $for));
            return $this->promptUser($io, $for, $validator);
        }

        return $value;
    }

    protected function createNewSuperuser(ConsoleIo $io, ?string $email = null): void
    {
        $table = $this->fetchTable();
        $emailValidator = $table->getValidator('email');

        if ($email === null || $this->handleValidationAndHasErrors($io, $emailValidator, compact('email'))) {
            $email = $this->promptUser($io, 'email', $emailValidator);
        }

        $isNew = false;

        try {
            /** @var \App\Model\Entity\User $user */
            $user = $table->findOrCreate(
                ['email' => $email],
                function (User $user) use ($io, &$isNew, $table) {
                    $isNew = true;
                    $user->is_superuser = true;
                    $user->password = $this->promptUser($io, 'password', $table->getValidator('password'));
                },
                ['validate' => false],
            );
        } catch (Exception $e) {
            $io->abort($e->getMessage());
        }

        if ($isNew) {
            $io->success('A new superuser has been created');
        } else {
            $io->warning(__('User already exists. {0}', match($user->is_superuser) {
                true => 'Nothing to do',
                false => 'Rerun with \'promote\' to elevate user',
            }));
        }
    }

    protected function modifyExistingUser(ConsoleIo $io, string $action = 'promote', ?string $email = null)
    {
        $table = $this->fetchTable();
        $emailValidator = $table->getValidator('email');

        if ($email === null || $this->handleValidationAndHasErrors($io, $emailValidator, compact('email'))) {
            $email = $this->promptUser($io, 'email', $emailValidator);
        }

        $user = $table->findByEmail($email)->first();

        if (!$user) {
            $io->warning('User does not exist.');
            return;
        }

        $valueToSet = ['promote' => true, 'demote' => false][$action];

        if ($user->is_superuser === $valueToSet) {
            $io->warning(__('User is already {0}d', $action));
            return;
        }

        $user->is_superuser = $valueToSet;
        if ($table->save($user)) {
            $io->success(__('User was {0}d', $action));
            return;
        }
        
        $io->abort(__('User could not be {0}d', $action));
    }
}
