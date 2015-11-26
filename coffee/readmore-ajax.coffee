jQuery().ready ($) ->
    $('#readmore').click () ->

        url = READMORE.endpoint
        query =
            action: READMORE.action
            count: 10
        console.log url,query

        $.get url, query, (res)->
            $('#readmore').before $ res
