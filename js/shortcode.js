(function() {
    tinymce.create('tinymce.plugins.code', {
        init : function(ed, url) {

            ed.addButton('codebutton', {
                title : 'Code',
                cmd : 'codebutton',
                image :  url + '/code.png'
            });

            ed.addCommand('codebutton', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = "[poll poll_id='" + selected_text + "'/]";
                ed.execCommand('mceInsertContent', 0, return_text);
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'mycodebutton', tinymce.plugins.code );
})();