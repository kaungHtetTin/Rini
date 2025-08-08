document.addEventListener('DOMContentLoaded', function () {
    let codeMode = false;

    // Add event listeners to toolbar buttons
    document.querySelectorAll('#toolbar button[data-command]').forEach(button => {
        button.addEventListener('click', function () {
            const command = this.getAttribute('data-command');
            if (command === 'increaseTextSize') {
                changeTextSize(2); // Increase text size
            } else if (command === 'decreaseTextSize') {
                changeTextSize(-2); // Decrease text size
            } else {
                document.execCommand(command, false, null);
            }
           // document.execCommand(command, false, null);
            toggleHighlight(this);
        });
    });

    // Add event listener to Code button
    document.getElementById('codeBtn').addEventListener('click', function () {
        if (codeMode) {
            codeMode = false;
            moveCaretToEndOfNode(document.querySelector('#editor').lastChild);
        } else {
            codeMode = true;
            insertCodeBlock();
        }
        toggleHighlight(this);
    });

    // Add event listener to Image button
    // document.getElementById('imageBtn').addEventListener('click', function () {
    //     insertImage();
    //     toggleHighlight(this);
    // });

    function insertCodeBlock() {
        const codeBlock = document.createElement('pre');
        const codeElement = document.createElement('code');
        codeElement.setAttribute('contenteditable', 'true');
        codeBlock.appendChild(codeElement);
        
        const selectedText = getSelectedText();
        removeSelectedText();
        
        codeElement.textContent = selectedText;
        document.getElementById('editor').appendChild(codeBlock);
        document.getElementById('editor').appendChild(document.createElement('br'));
    }

    function moveCaretToEndOfNode(node) {
        const range = document.createRange();
        const sel = window.getSelection();
        range.setStartAfter(node);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
    }

    function insertImage() {
        const url = prompt("Enter image URL:");
        if (url) {
            document.execCommand('insertImage', false, url);
        }
    }

    function toggleHighlight(button) {
        document.querySelectorAll('#toolbar button').forEach(btn => btn.classList.remove('active'));
        button.classList.toggle('active');
    }

    function highlightCodeBlocks() {
        document.querySelectorAll('pre code').forEach(block => {
            block.setAttribute('contenteditable', 'true');
            Prism.highlightElement(block);
        });
    }

    document.getElementById('editor').addEventListener('paste', function () {
        setTimeout(highlightCodeBlocks, 10);
    });

    function getSelectedText() {
        let selectedText = '';
        if (window.getSelection) {
            selectedText = window.getSelection().toString();
        } else if (document.selection && document.selection.type !== "Control") {
            selectedText = document.selection.createRange().text;
        }
        return selectedText;
    }

    function removeSelectedText() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            range.deleteContents();
        }
    }

    function changeTextSize(change) {
        let sel = window.getSelection();
        if (!sel.rangeCount) return;

        const range = sel.getRangeAt(0);
        const startContainer = range.startContainer;
        const endContainer = range.endContainer;

        // Create a span element to apply new font size
        const span = document.createElement('span');
        let currentSize = getComputedStyle(startContainer.parentNode).fontSize;
        currentSize = parseFloat(currentSize);

        // Calculate new size
        const newSize = Math.max(8, currentSize + change); // Prevent font size from going below 8px
        span.style.fontSize = `${newSize}px`;

        // Wrap selected text with the new span element
        range.surroundContents(span);

        // Optional: Move the caret to the end of the selection
        const newRange = document.createRange();
        sel = window.getSelection();
        newRange.setStartAfter(span);
        newRange.collapse(true);
        sel.removeAllRanges();
        sel.addRange(newRange);
    }
    
    function increaseTextSize() {
        const sel = window.getSelection();
        if (!sel.rangeCount) return;

        const range = sel.getRangeAt(0);
        const selectedText = range.toString();
        
        if (selectedText) {
            const span = document.createElement('span');
            span.style.fontSize = '18px'; // Example size, adjust as needed
            span.textContent = selectedText;
            range.deleteContents();
            range.insertNode(span);
        }
    }
});
