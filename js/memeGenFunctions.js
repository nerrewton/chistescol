/**
 * Created by Rene Arteaga on 14/10/2017.
 */

$(".bootstrap img").memeGenerator({
    useBootstrap: true
});

// to download image

$("#download").click(function(e){
    e.preventDefault();

    $("#image-to-download").memeGenerator("download");
});