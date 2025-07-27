
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Load More</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>

      

<div class="container mt-5" style="max-width: 750px">

  

    <h5 style="text-align:center">Load More Data on Button Click using JQuery+Laravel</h5>

  

    <div id="data-wrapper">

        @include('data')

    </div>

@if($morePosts)
    <div class="text-center">
        <button class="btn btn-success load-more-data" style='display:inline-block'><i class="fa fa-refresh"></i> Load More Data...</button>
    </div>
@else
        <div class="auto-load text-center">
<p>We don't have more data to display.</p>
    </div>
@endif
<div class="text-center mt-2">
    <button class="btn btn-warning load-less-data" style="display: none;"><i class="fa fa-minus-circle"></i> Load Less</button>
</div>
  

    <!-- Data Loader -->

    <div class="auto-load text-center" style="display: none;">


    </div>

</div>

  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

    var ENDPOINT = @json(route('posts.index'));

    var page = 1;
    let lastPage = @json($lastPage);

    $(".load-more-data").click(function(){
        page++;

        infinteLoadMore(page);

    });


  $(".load-less-data").click(function () {
    page--;
    if(page==1){
        $('.load-less-data').css('display', 'none');
    }
    if(page!=lastPage){
            $('.load-more-data').css('display', 'inline-block');
    }
    $.ajax({
        url: ENDPOINT + "?page=" + page,
        type: "GET",
        beforeSend: function () {
            $('.auto-load').show();
        },
        success: function (response) {
            $('.auto-load').hide();
            $("#data-wrapper").html(response.html); 
        },
        error: function () {
            console.log('Error loading less data.');
        }
    });
});

    /*------------------------------------------

    --------------------------------------------

    call infinteLoadMore()

    --------------------------------------------

    --------------------------------------------*/

    function infinteLoadMore(page) {
        console.log(page);
        if(page >1){
            $('.load-less-data').css('display', 'inline-block');
        }

        if(page==lastPage){
            $('.load-more-data').css('display', 'none');
        }


        $.ajax({

                url: ENDPOINT + "?page=" + page,

                datatype: "html",

                type: "get",

                beforeSend: function () {

                    $('.auto-load').show();

                }

            })

            .done(function (response) {

                if (response.html == '') {

                    $('.auto-load').html("We don't have more data to display");

                    return;

                }

                $('.auto-load').hide();

                $("#data-wrapper").append(response.html);

            })

            .fail(function (jqXHR, ajaxOptions, thrownError) {

                console.log('Server error occured');

            });

    }

</script>

</body>

</html>