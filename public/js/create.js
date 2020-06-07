

var $collectionHolder;

// setup an "add a tag" link"
var $addTagButton = $('<button type="button" class="btn btn-secondary add_tag_link mb-4">+</button>');
var $newLinkLi = $('<div></div>').append($addTagButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('div.locations');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);


    $collectionHolder.data('index', index + 1);


    var $newFormLi = $('<div></div>').append(newForm);
    $newLinkLi.before($newFormLi);

    $newFormLi.before('<hr class="mt-4 mb-4" />')
}