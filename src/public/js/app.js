function deleteInput(event) {
    const targ = jQuery(event.target || event.srcElement);
    targ.closest('.js-parent-container').remove();
    refreshDocument();
}

function addInput(event)
{
    let targ = jQuery(event.target || event.srcElement);

    if (targ.prop('tagName').toLowerCase() !== 'a')
    {
       targ = targ.closest('a');
    }

    const view = targ.attr('data-view');
    const sortGroup = targ.closest('.js-parent-container')
        .find('.js-sort-group').first();
    const indexParts = sortGroup.find('input').first().attr('name').split('][');
    const index = indexParts.length === 4
        ? Number(indexParts[1])
        : Number(indexParts[1]) + 1;

    const settings = {
        url: `/document?view=${view}&index=${index}`,
        type: 'GET',
    };

    jQuery.ajax(settings).done(function(data, textStatus, jqXHR) {
        sortGroup.append(data.body);
        makeSortable();
    });
}

let refreshTimer = null;

function refreshPreview() {
    if (refreshTimer !== null)
    {
        clearTimeout(refreshTimer);
        refreshTimer = null;
    }

    refreshTimer = setTimeout(() => {
        const form = jQuery('#document-form');
        const settings = {
            url: '/document?view=document.preview',
            type: 'POST',
            data: form.serialize()
        };

        jQuery.ajax(settings).done(function(data, textStatus, jqXHR) {
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
