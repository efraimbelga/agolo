$(function () {
    $('#masterlistTbl').DataTable({
      'paging'      : true,
      'ordering'    : true,
      'info'        : true,
      'scrollX'     : true,
      'scrollY'     : '600px',
      'scrollCollapse': true,
      'fixedHeader' : true
    })
  })