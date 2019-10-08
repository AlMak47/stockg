//
var myVue = {
  getSalesList : function (token,url,tag) {
    // recuperation de la liste des ventes
    var form = $adminPage.makeForm(token,url,tag)
    form.on('submit',function(e){
      e.preventDefault()
      $.ajax({
        url : $(this).attr('action'),
        type : 'post',
        dataType : 'json',
        data : $(this).serialize()
      })
      .done(function (data) {
        console.log($("#loading"))
        $("#loading").hide(300)
        myVue.dataList(data,$("#l-vente"))

      })
      .fail(function (data) {
        console.log(data)
      })
    })
    form.submit()
  },
  dataList : function (data,content) {
    var row = [] , cols = [] ;
    data.forEach(function (element,index) {
      row[index] = $("<tr></tr>")
      var count = 0 ;
      for(var prop in element) {
        cols [count] = $("<td></td>")
        cols[count].text(element[prop])
        row[index].append(cols[count])
        content.append(row[index])
        count++
      }
    })

  }
}
