$(".clickable-row").click(function() {
    window.location = $(this).data("href");
    console.log("test");
});

function mileageCalculator(val, ppm, output)
{
    let total = parseFloat(val) * ppm;
    $('#'+output).text("£"+(Math.round(total*100)/100).toString());
}