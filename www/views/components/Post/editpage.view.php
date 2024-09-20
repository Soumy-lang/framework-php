<script src="https://cdn.tiny.cloud/1/o266b8aysxjdpdnudib5pwdhu8gy1ktpyzfmzz7nhwsa8f7d/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<h2>Apperçu de la page</h2>
<section class="middle-section">
    <div class="form-bloc">
        <?php $this->includeComponent("form", $configForm, $errorsForm, $successForm, "button button-primary");?>
    </div>
</section>

<script>
  tinymce.init({
    selector: '#mytextarea',
    plugins: 'image',
    toolbar: 'image',
    image_title: true,
    paste_as_text: true, 
    automatic_uploads: true,
    images_upload_url: '/upload-image',
    file_picker_types: 'image',
    file_picker_callback: function (callback, value, meta) {
      if (meta.filetype === 'image') {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        
        input.onchange = function () {
          var file = this.files[0];
          var reader = new FileReader();
          reader.onload = function () {
            callback(reader.result, { alt: file.name });
          };
          reader.readAsDataURL(file);
        };
        input.click();
      }
    }
  });


</script>
