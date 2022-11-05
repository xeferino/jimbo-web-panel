'use strict';
const APP_URL = $('meta[name="base-url"]').attr('content');
const JIMBO = { url : '/panel/dashboard' };
//alert(JIMBO.url)
$(function () {
    /* Morris.Area({
            element: 'graph',
            data: [
            {x: '2010', y: 3, z: 52},
            {x: '2011', y: 3, z: 4},
            {x: '2011', y: null, z: 1},
            {x: '2011', y: 2, z: 5},
            {x: '2011', y: 50, z: 2},
            {x: '2012', y: 4, z: 4}
            ],
            xkey: 'x',
            ykeys: ['y', 'z'],
            labels: ['Y', 'Z']
    }).on('click', function(i, row){
        console.log(i, row);
    }); */

    /* Morris.Bar({
    element: 'graph-bar',
    data: [
        {x: '2011 Q1', y: 3, z: 2, a: 3},
        {x: '2011 Q2', y: 2, z: null, a: 1},
        {x: '2011 Q3', y: 0, z: 2, a: 4},
        {x: '2011 Q4', y: 2, z: 4, a: 3}
    ],
    xkey: 'x',
    ykeys: ['y', 'z', 'a'],
    labels: ['Y', 'Z', 'A']
    }).on('click', function(i, row){
    console.log(i, row);
    }); */

    /* Morris.Donut({
        element: 'graph-donut',
        data: [
          {value: 70, label: 'Usuario'},
          {value: 15, label: 'Clasico'},
          {value: 10, label: 'Junior'},
          {value: 5, label: 'Semi Senior'},
          {value: 5, label: 'Senior'}
        ],
        backgroundColor: '#ccc',
        labelColor: '#000',
        colors: [
          '#cc7514',
          '#8a5112',
          '#eb8413',
          '#e69232',
          '#eda85c'
        ],
        //formatter: function (x) { return x + "%"}
    }); */

    /* const ctx = document.getElementById('myChart');
    const ctx = document.getElementById('myChart').getContext('2d');
    const ctx = $('#myChart');
    const ctx = 'myChart'; */
});
