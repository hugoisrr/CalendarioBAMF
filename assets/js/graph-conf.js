var Script = function () {

    //morris chart

    $(function () {      

      Morris.Donut({
        element: 'hero-donut',
        data: [
          {label: 'Juan', value: 25 },
          {label: 'Flor', value: 40 },
          {label: 'Carlos', value: 25 },
          {label: 'Samuel', value: 10 }
        ],
          colors: ['#3498db', '#2980b9', '#34495e'],
        formatter: function (y) { return y + "hrs" }
      });

      $('.code-example').each(function (index, el) {
        eval($(el).text());
      });
    });

}();




