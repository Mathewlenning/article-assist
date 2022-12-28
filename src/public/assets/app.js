function deleteInput(event) {
    const targ = jQuery(event.target || event.srcElement);
    targ.closest('.js-parent-container').remove();
    refreshDocument();
}

function addInput(event)
{
    let targ = jQuery(event.target || event.srcElement);

    if (targ.prop('tagName').toLowerCase() !== 'a') {
       targ = targ.closest('a');
    }

    const view = targ.attr('data-view-template');
    const sortGroup = targ.closest('.js-parent-container')
        .find('.js-sort-group').first();
    const indexParts = sortGroup.find('input').first().attr('name').split('][');
    const index = indexParts.length === 4
        ? Number(indexParts[1])
        : Number(indexParts[1]) + 1;

    const url = `/documents/form?view_template=${view}&index=${index}`;

    makeRequest(url, 'get').done(function(data, textStatus, jqXHR) {
        sortGroup.append(data.body);
        makeSortable();
    });
}

function makeRequest(url, type, settings = {})
{
    settings.url = url;
    settings.type = type.toUpperCase();
    return jQuery.ajax(settings);
}

function testPost()
{
    const settings = {
        data: jQuery('#document-form').serialize()
    }

    settings.data._method='put';

    return makeRequest('/documents/form', 'post', settings);

}

let refreshTimer = null;

function refreshPreview() {
    if (refreshTimer !== null) {
        clearTimeout(refreshTimer);
        refreshTimer = null;
    }

    refreshTimer = setTimeout(() => {
        const form = jQuery('#document-form');
        const data = form.serialize();

        const url = `/documents/form?view_template=documents.form.preview&${data}`;
        makeRequest(url, 'GET').done(function(data, textStatus, jqXHR) {
            jQuery('.js-preview-container').html(data.body);
        });

        refreshTimer = null;
    }, 300)
}

function refreshDocument()
{
   jQuery('#js-sortable-paragraphs li').each((index, element) => {
        element = jQuery(element);
        element.find('input[name$="[primary_argument]"]').attr('name', `document[paragraphs][${index}][primary_argument]`);
        element.find('input[name$="[supporting_arguments][]"]').attr('name', `document[paragraphs][${index}][supporting_arguments][]`);
    });

   refreshPreview();
}

function showSupportingArguments(event){
    const targ = jQuery(event.target || event.srcElement);
    const sibling = targ.closest('.js-parent-container').find('.js-accordion');

    if (sibling.hasClass('show')) {
        return;
    }

    jQuery('.js-accordion.show').collapse('hide');
    sibling.collapse('show');
}
