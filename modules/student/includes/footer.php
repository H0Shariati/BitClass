<?php
if($_SESSION['role']!=1){
    die('ACCESS DENIED!');
}
?>
</div>
<!-- Page content END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="assets/vendor/apexcharts/js/apexcharts.min.js"></script>
<script src="assets/vendor/overlay-scrollbar/js/overlayscrollbars.min.js"></script>



<script src="assets/vendor/choices/js/choices.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.js"></script>
<script src="assets/vendor/quill/js/quill.min.js"></script>
<script src="assets/vendor/stepper/js/bs-stepper.min.js"></script>



<!-- Template Functions -->
<script src="assets/js/functions.js"></script>
<script src="assets/js/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.editor'), {

            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    'code',
                    'codeBlock',
                    'fontBackgroundColor',
                    'fontColor',
                    'fontSize',
                    'highlight'
                ]
            },
            language: 'fa',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side',
                    'linkImage'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',


        })
        .then(editor => {
            window.editor = editor;








        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: fotmady28o1t-fx1wlfayz8ed');
            console.error(error);
        });
</script>
<script>
    document.querySelector(".upload-button").onclick = function() {
        document.querySelector(".hidden-upload").click();
    };

    document.querySelector(".hidden-upload").onchange = function() {
        document.querySelector(".upload-name").value = event.target.files[0].name;
    };
    // Upload File .mp4
    document.querySelector(".upload-button-mp4").onclick = function() {
        document.querySelector(".hidden-upload-mp4").click();
    };

    document.querySelector(".hidden-upload-mp4").onchange = function() {
        document.querySelector(".upload-name-mp4").value = event.target.files[0].name;
    };
    // Upload File .WebM
    document.querySelector(".upload-button-web").onclick = function() {
        document.querySelector(".hidden-upload-web").click();
    };

    document.querySelector(".hidden-upload-web").onchange = function() {
        document.querySelector(".upload-name-web").value = event.target.files[0].name;
    };
    // Upload File .OGG
    document.querySelector(".upload-button-ogg").onclick = function() {
        document.querySelector(".hidden-upload-ogg").click();
    };

    document.querySelector(".hidden-upload-ogg").onchange = function() {
        document.querySelector(".upload-name-ogg").value = event.target.files[0].name;
    };
</script>

</body>
</html>

