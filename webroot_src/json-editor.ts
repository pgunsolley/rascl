import JSONEditor from "jsoneditor"

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById("descriptor");
    if (container !== null) {
        const editor = new JSONEditor(container);
        const initialJson = {
            "Array": [1, 2, 3],
            "Boolean": true,
            "Null": null,
            "Number": 123,
            "Object": {"a": "b", "c": "d"},
            "String": "Hello World",
        };
        editor.set(initialJson);
        const updatedJson = editor.get();
        console.log('JSONEditor loaded');
    }
});
