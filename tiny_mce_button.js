(function() {
    tinymce.create('tinymce.plugins.code', {
        init : function(ed, url) {

            ed.addButton('codebutton', {
                title : 'WP EASY POLL',
                cmd : 'codebutton',
                image :  url + '/voting_poll.png'
            });

            ed.addCommand('codebutton', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                
                
            
    var poll_id = prompt("Enter poll id");

                return_text = '[poll poll_id="' + poll_id + '"]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'mycodebutton', tinymce.plugins.code );
})();