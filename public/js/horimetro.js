
$('#form1').submit(function (e) {
  e.preventDefault();


  let x = $('#name').val();
  let y = $('#comment').val();
  let valorhora = $('#valhora').val();
  var restquant = y - x;
  var rest = (y - x) * valorhora;

  function getComments () {



    //document.getElementById("demo").innerHTML = x + "<br>" + y + "<br>" + parseFloat(restquant.toFixed(2));

    document.getElementById("tothorimetro").innerHTML = parseFloat(rest.toFixed(1));

    $('.box_comment').prepend('<div class="b_comm"><h4>' + x + "<br>" + y + "<br>" + parseFloat(rest.toFixed(2)) + '</h4></div>');

    var why = $('input[name="why"]').val();
  }

  getComments();
});