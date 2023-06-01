<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/quill/dist/quill.min.js') }}"></script>
<script>
    function checkAll(o) {
        var boxes = document.getElementsByTagName('input');
        for (var x = 0; x < boxes.length; x++) {
            var obj = boxes[x];
            if (obj.type == 'checkbox') {
                if (obj.name != 'check') obj.checked = o.checked;
            }
        }
    }

    function ClickSave() {
        let elements = document.querySelectorAll('.ql-editor');
        if (elements.length > 0) {
            elements.forEach(function (element) {
                element.closest('.myeditor').querySelector('.txtcont').value =
                    element.innerHTML;
            });
        }
    }
</script>
