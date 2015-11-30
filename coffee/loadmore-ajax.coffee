jQuery().ready ($) ->
    $('#loadmore-button').click () ->
        url = LOADMORE.endpoint
        query =
            action: LOADMORE.action
            query: $('#end-of-articles').data 'query'
            count: $('#main>article').length - $('#main>article.sticky').length
            nonce: $('#ajax-nonce').val()
        console.log url,query
        $.get url, query, (res)->
            console.log res
            $('#end-of-articles').before $ res
