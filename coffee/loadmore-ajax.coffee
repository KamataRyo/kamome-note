'use strict'
loading = false

jQuery().ready ($)->
    checkAndHide = ()->
        if $('#main article').length >= parseInt($('#published_posts').val(), 10)
            $('#loadmore-button').fadeOut 300

    checkAndHide()

    $('#loadmore-button').click () ->
        if loading then return

        loading = true
        $('body, #loadmore-button').css 'cursor', 'wait'

        url = LOADMORE.endpoint
        query =
            action:   LOADMORE.action
            query:    $('#end-of-articles').data 'query'
            stickies: $('#ids_of_stickies').val()
            nonce:    $('#ajax-nonce').val()

        $.get url, query, (res) ->
            query.query.paged++; #次ページにする

            $('#end-of-articles')
                .data 'query', query.query

            $(res).appendTo $('#articles_wrapper')
                .hide()
                .fadeIn 300, ->
                    $('body').css 'cursor', 'auto'
                    $('#loadmore-button').css 'cursor', 'pointer'
                    loading = false

            checkAndHide()
