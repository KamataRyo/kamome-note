jQuery().ready ($)->

    checkAndHide = ()->
        if $('#main>article').length >= parseInt($('#published_posts').val(), 10)
            $('#loadmore-button').css 'display', 'none'

    checkAndHide()

    $('#loadmore-button').click () ->
        url = LOADMORE.endpoint
        query =
            action:   LOADMORE.action
            query:    $('#end-of-articles').data 'query'
            stickies: $('#ids_of_stickies').val()
            nonce:    $('#ajax-nonce').val()
        $.get url, query, (res)->
            query.query.paged++;
            $('#end-of-articles')
                .before $ res
                .data 'query', query.query
                checkAndHide()
