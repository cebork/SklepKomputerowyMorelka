$(document).ready(function(){
    $('.choose').change(function(){
        $('#formularz').load('../formularze/addform.php?tabela='+$(this).val());
    });
});
$(document).ready(function() {
    $(".clickable").click(function() {
        window.location = $(this).data("href");
    });
});

$(document).ready(function(){
    $('.searchEdit').load('../content/searchItemEdit.php');
});

function searchItems(){
    $(".searchEdit").load('../content/searchItemEdit.php?phrase='+$('#fraza').val()); 
}

$(document).ready(function(){
    $('.searchEditUsers').load('../content/searchUsers.php');
});

function searchUser(){
    $(".searchEditUsers").load('../content/searchUsers.php?phrase='+$('#fraza').val()); 
}

$('#button').on('click', function() {
    var form = $('#form');
    var num = parseInt(form.find('input:last-of-type').attr('name')) + 1;
    form.append('<input class="newinput form-control type="text" name="' + num + '" />');
 });

 function raporty() {
    $("#raporty").load('../content/raportselekcja.php?date_start='+$('#date_start').val()+'&date_end='+$('#date_end').val()+'&raport='+$('#raport').val());  
}

