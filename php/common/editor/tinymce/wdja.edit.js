tinymce.init({
                selector: '.wdjaedit',
                convert_urls: false,
                remove_script_host: false,
                  height: 300,
                  plugins: [
                    "advlist autolink autosave link image lists charmap preview hr anchor pagebreak",
                    "searchreplace wordcount code fullscreen insertdatetime media nonbreaking",
                    "table directionality textcolor powerpaste textcolor colorpicker textpattern codesample"
                  ],
                  end_container_on_empty_block:true,
                  paste_data_images:true,
                  powerpaste_word_import: 'propmt',
                  powerpaste_html_import: 'propmt',
                  powerpaste_allow_local_images: true,
                  toolbar1: "undo redo | bold italic underline strikethrough removeformat | subscript superscript | alignleft aligncenter alignright alignjustify | forecolor backcolor formatselect fontselect",
                  toolbar2: "table searchreplace | ltr rtl | bullist numlist | outdent indent | link unlink anchor image media | insertdatetime charmap hr nonbreaking pagebreak | preview fullscreen codesample code",
                  menubar: false,
                  toolbar_items_size: 'small',
                  language:'zh_CN'
            })
function editor_insert(strid, strers)
{
  tinyMCE.execCommand("mceInsertContent", false, strers);
}