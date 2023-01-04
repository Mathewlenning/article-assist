article_assist = window.article_assist || {};

article_assist.util = {
    getEventTarg: function (event) {
        return jQuery(event.target || event.srcElement);
    },

    makeRequest: function (url, type, settings = {}) {
        settings.url = url;
        settings.type = type.toUpperCase();
        return jQuery.ajax(settings);
    },

    makeSortable: function (selector, settings = null){
        jQuery(selector).sortable(settings);
    }
}

article_assist.documents = {
    deleteInput: function (event) {
        const targ =  article_assist.util.getEventTarg(event);
        targ.closest('js-parent-container').remove();
        article_assist.documents.refreshDocument();
    },

    refreshDocument: function () {
        jQuery('#js-sortable-paragraphs li').each((index, element) => {
            element = jQuery(element);
            element.find('input[name$="[primary_argument]"]').attr('name', `document[paragraphs][${index}][primary_argument]`);
            element.find('input[name$="[supporting_arguments][]"]').attr('name', `document[paragraphs][${index}][supporting_arguments][]`);
        });
        article_assist.documents.refreshPreview();
    },

    previewRefreshTimer:null,

    refreshPreview: function () {
        if ( article_assist.documents.previewRefreshTimer !== null) {
            clearTimeout(article_assist.documents.previewRefreshTimer);
            article_assist.documents.previewRefreshTimer = null;
        }

        article_assist.documents.previewRefreshTimer = setTimeout(() => {
            const data = jQuery('#document-form').serialize();
            const url = `/documents/form?view_template=documents.form.preview&${data}`;

            article_assist.util.makeRequest(url, 'GET').done(function(data, textStatus, jqXHR) {
                jQuery('.js-preview-container').html(data.body);
            });

            article_assist.documents.previewRefreshTimer = null;
        }, 300)
    },

    addInput:function (event) {
        let targ =  article_assist.util.getEventTarg(event);

        if (targ.prop('tagName').toLowerCase() !== 'a') {
            targ = targ.closest('a');
        }
        const sortGroup = targ.closest('.js-parent-container').find('.js-sort-group').first();
        const viewTemplate = targ.attr('data-view-template');
        const url = `/documents/form?view_template=${viewTemplate}`;

        article_assist.util.makeRequest(url, 'get')
            .done(function(data, textStatus, jqXHR) {
                sortGroup.append(data.body);
                article_assist.documents.refreshDocument();
                article_assist.documents.initSortable();
            });
    },
    initSortable: function() {
        article_assist.util.makeSortable('#js-sortable-paragraphs', {
            handle: '.js-sortable-handle',
            animation: 150,
            onEnd: (event) => {
                article_assist.documents.refreshDocument();
            }
        });

        article_assist.util.makeSortable('.js-sortable-sentences', {
            handle: '.js-sortable-handle',
            animation: 150,
            onEnd: (event) => {
                article_assist.documents.refreshDocument();
            }
        });
    },
    showSupportingArguments: function (event) {
        const targ = article_assist.util.getEventTarg(event);
        const sibling = targ.closest('.js-parent-container').find('.js-accordion');

        if (sibling.hasClass('show')) {
            return;
        }

        jQuery('.js-accordion.show').collapse('hide');
        sibling.collapse('show');
    }
};
article_assist.keyboard = {
    dispatch: function (event) {
        const key = event.key.toLowerCase();
        switch (key) {
            case 'insert':
            case 'enter':
            case 'backspace':
            case 'delete':
                article_assist.keyboard[key](event);
                break;
      }
    },

    insert: function (event){
        let targ =  article_assist.util.getEventTarg(event);

        const sortGroup = targ.closest('.js-sort-group');
        const viewTemplate = targ.attr('data-view-template');
        const url = `/documents/form?view_template=${viewTemplate}`;

        article_assist.util.makeRequest(url, 'get')
            .done(function(data, textStatus, jqXHR) {
                sortGroup.append(data.body);
                article_assist.documents.refreshDocument();
                article_assist.documents.initSortable();
                sortGroup.find('input').last().focus();
            });
    },

    enter: function (event) {

    },

    backspace: function (event){

    },

    delete: function (event) {
        console.log(event.keyCode);
        const targ =  article_assist.util.getEventTarg(event);
        const parent = targ.closest('.js-parent-container');
        parent.remove();
        article_assist.documents.refreshDocument();
    }
}
