<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown Editor with Character Limit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
</head>
<body>
    <h2>Markdown Editor (Character Limit: 200)</h2>
    <textarea id="editor"></textarea>
    <p id="charCount">0/200 characters</p>
    <h3>Preview</h3>
    <div id="preview"></div>
    <!-- SimpleMDE JavaScript -->
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        const maxChars = 200;

        // Initialize SimpleMDE
        var simplemde = new SimpleMDE({ 
            element: document.getElementById("editor"),
            toolbar: [
                "bold", "italic", "heading", "|",
                "quote", "unordered-list", "ordered-list", "|",
                "preview", "side-by-side", "fullscreen"
            ]
        });

        // Update character count and enforce limit
        simplemde.codemirror.on("change", function() {
            let content = simplemde.value();
            let charCount = content.length;

            // Check if the character limit is exceeded
            if (charCount > maxChars) {
                // Trim content to maxChars if limit exceeded
                simplemde.value(content.substring(0, maxChars));
                charCount = maxChars;
            }

            // Update character count display
            document.getElementById("charCount").innerText = `${charCount}/${maxChars} characters`;
        });

        simplemde.codemirror.on("change", function(){
            document.getElementById("preview").innerHTML = simplemde.options.previewRender(simplemde.value());
        });
    </script>
</body>
</html>