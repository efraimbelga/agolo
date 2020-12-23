$(function(){
    var page = 1;
    var fetch = 10;
    loadMasterlist(page, fetch)

    function loadMasterlist(page) {
        var jqxhr = $.post(domain+'Masterlist_controller/loadMasterlist', {page:page, fetch:fetch}, function(result) {
            $('.table-holder').html(result)
        }).fail(function() {
            alert( "error" );
        });
    }
    
    $(document).on('click', '.gotopage', function(e){
        e.preventDefault();
        var page = $(this).attr('data-value');
        loadMasterlist(page, fetch)
    })

    $(document).on('submit', '#searchform', function(e){
        e.preventDefault();
        var value = $('#searchkey').val().toLowerCase();
        $("#masterlistTbl tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    })


    $(document).on('click','.download-btn', function(){
        var value = $('#searchkey').val().toLowerCase();
        window.open(domain+'masterlist/download', '_blank');
    })
});
