window.addEventListener('load', function() {
    var editor;
});
editor = ContentTools.EditorApp.get();
editor.init('*[data-editable]', 'data-name');
ContentTools.CANCEL_MESSAGE = 'Vos changements n\'ont pas été sauvegardés, voulez vous vraiment les perdre ?'.trim()


editor.addEventListener('saved', function (ev) {
    var name, onStateChange, passive, payload, regions, xhr;

    // Check if this was a passive save
    passive = ev.detail().passive;

    // Check to see if there are any changes to save
    regions = ev.detail().regions;

    if (Object.keys(regions).length == 0) {
        return;
    }
    // Set the editors state to busy while we save our changes
    this.busy(true);

    // Collect the contents of each region into a FormData instance
    payload = new FormData();
    // payload.append('__page__', window.location.pathname);
    for (name in regions) {
        payload.append(name, regions[name]);
    }
    payload.append('_method', 'PUT');
    if(window.location.pathname.substr(-3) == 'new'){
        var created_at = document.getElementById("created_at").value; 
        var books_id = document.getElementById("books_id").value; 
        var chapters_order = document.getElementById("chapters_order").value; 
        payload.append('created_at', created_at);
        payload.append('books_id', books_id);
        payload.append('chapters_order', chapters_order);
        payload.append('_method', 'POST');
    }

    // Send the update content to the server to be saved
    onStateChange = function(ev) {
        // Check if the request is finished
        if (ev.target.readyState == 4) {
            editor.busy(false);
            if (ev.target.status == '200') {
                // Save was successful, notify the user with a flash
                if (!passive) {
                    new ContentTools.FlashUI('ok');
                }
            } else {
                // Save failed, notify the user with a flash
                new ContentTools.FlashUI('no');
            }
        }
    };

        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', onStateChange);
        xhr.open('POST', window.location.pathname, true);
        xhr.send(payload); 
});
