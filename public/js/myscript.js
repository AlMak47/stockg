//

//


var $adminPage = {
	makeForm : function (formToken,url,reference) {
		var form = $("<form></form>");form.attr('action',url);form.attr('method','post');
			var token = $("<input/>");
			var ref = $("<input/>");
			ref.attr('type','hidden');
			ref.attr('name','ref');
			ref.val(reference);
			token.attr('type','hidden');
			token.attr('name','_token');
			token.val(formToken);
			form.append(token);
			form.append(ref);
			return form;
	},

	getDataFormAjax : function (reference,formToken,url,tab,table,options,dashOption=false) {
		var quantite = null;
		if(reference) {
			var form=$adminPage.makeForm(formToken,url,reference);
			form.on('submit',function (e) {
				e.preventDefault();
				$.ajax({
					url : $(this).attr('action'),
					type : $(this).attr('method'),
					dataType:'json',
					data : $(this).serialize()
				})
				.done(function (data) {
					$adminPage.createTableRow(data,tab,table,options,dashOption);
					$adminPage.showImage();
					$adminPage.addItemToCommand($('.add-button'));
					// $('.edit-button').hide();
				})
				.fail(function (data) {
					return data
				});
			});
		}
			form.submit();
	}

};

$adminPage.createTableRow = function (sdata,champs=null,table,options,dashOption) {
		 	table.html('');
		 	//
		 	var list=[];
		 	// var champs = ['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'];
					for(var i=0;i<sdata.length;i++) {
						var td=[]
						list[i]=$("<tr></tr>");
						list[i].addClass('uk-animation-toggle');
						for(var j=0;j<champs.length;j++) {
							td[j] =$("<td></td>");
						}
						td[0].text(sdata[i].libelle);
						td[1].text(sdata[i].quantite);
						td[3].text(sdata[i].prix_achat);
						td[2].text(sdata[i].prix_unitaire);
						//


						$adminPage.getAction(options,td,sdata[i].reference,dashOption);
						// link.attr('href','')

						//
						// var img = $('<img/>');
						// img.addClass('uk-preserve-width'); img.attr('src',"{{asset('uploads/')}}"+'/'+sdata[i].photo);
						var img = $('<span><span/>');img.addClass('uk-icon uk-icon-image item-img');
						img.attr('uk-icon-image','ratio:2');
						img.attr('id',sdata[i].photo);
						// img.attr('style',"background-image : url({{asset('uploads/')}}"+"/"+sdata[i].photo+");");
						// img.attr('src',"{{asset('uploads/')}}"+'/'+sdata[i].photo);
						td[4].append(img);
						for(var j=0;j<champs.length;j++) {
							list[i].append(td[j]);
						}

						if(sdata[i].date) {
							td[2].text(sdata[i].date);
							td[3].text(sdata[i].prix_unitaire);
							td[4].text(sdata[i].prix_achat);
							td[5].append(img);
						}

						table.append(list[i]);
					}
					$("td:empty").remove();


		 	//

		 };

		 $adminPage.getAction = function (options=1,td,link,dashOption=false) {
		 		var linkEdit = $("<a></a>");linkEdit.addClass('uk-button uk-button-link uk-text-capitalize');
				var linkDetails = linkEdit.clone();
		 	if(options==1) {
		 		// make edit button
						linkEdit.text('Edit');
						linkEdit.addClass('edit-button');
						linkDetails.text('Details');
						linkEdit.attr('href','edit-item/'+link);
					 	td[5].append(linkEdit);
					 	linkDetails.attr('href','item/'+link);
		 	} else {
		 		// make add button
		 		linkEdit.text('add');
		 		linkEdit.addClass('add-button');
		 		linkEdit.attr('id',link);
			 	td[5].append(linkEdit);
		 		// linkEdit.remove();
		 		if(dashOption) {
		 			linkEdit.remove();
		 		}
		 		linkDetails.attr('href','/gerant/item/'+link);
		 	}
			linkDetails.text('Details');
			td[6].append(linkDetails);
		 };


$adminPage.addItemToCommand  = function (item) {

	item.on('click',function () {
		var reference = $(this).attr('id');
		UIkit.modal.prompt('Entrez la quantite',1).then(function (quantite) {
			// if(typeOf(quantite))
			quantite = parseInt(quantite);
			if(quantite && quantite > 0) {
				// console.log(quantite);
				// return 0;
				var form = $adminPage.makeForm($('#token').val(),'add-item',reference);
				var inputQuantite = $("<input/>");inputQuantite.attr('name','quantite');inputQuantite.val(quantite);
				form.append(inputQuantite);
				form.on('submit',function (e) {
					e.preventDefault();
					$.ajax({
						url : $(this).attr('action'),
						type : $(this).attr('method'),
						data : $(this).serialize(),
						dataType:'json'
					})
					.done(function (data) {

						UIkit.modal.alert(data).then(function() {
							// RECUPERATION DE LA LISTE ACTUALISEE DES PRODUITS
							$adminPage.getDataFormAjax('all',$("#token").val(),'',['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"),2);
						});
					})
					.fail(function (data) {
						console.log(data);
					});
				});

				form.submit();
			} else {
				UIkit.modal.alert('La valeur ne peut etre nulle').then(function() {
					return 0;
				});
			}
			// return 0;
			//

		});
		// console.log(item);
	});
};

$adminPage.getPanier =function (token,url) {
	var form = $adminPage.makeForm(token,url,'');
	form.on('submit',function(e) {
		e.preventDefault();
		$.ajax({
			url:$(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType : 'json'
		})
		.done(function (data) {
			$("#panier").text(data.nb);
		})
		.fail(function (data) {
			console.log(data);
		});
	});
	form.submit();
};

$adminPage.detailsPanierOnGerant = function (token,url) {
	var form=$adminPage.makeForm(token,url,'');
	form.on('submit',function(e) {
		e.preventDefault();
		$.ajax({
			url : $(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType : 'json'
		})
		.done(function (data) {
			if(data =="indefinie") {
				UIkit.modal.alert('Aucune Commande en cours').then(function () {
					$(location).attr('href','');
				});
			}
			else {
				$("#load").fadeOut();
				$adminPage.createTableData(data.item_details,['libelle','quantite','prix_unitaire','total'],$("#details-panier"));
				$("#cash").html(data.total_cash);
			}
		})
		.fail(function(data) {
			console.log(data);
		});
	});
	form.submit();
};

$adminPage.createTableData = function (sdata,champs=null,table) {

		 	//
		 	table.html('');
		 	var list=[];

					for(var i=0;i<sdata.length;i++) {
						var td=[]
						list[i]=$("<tr></tr>");
						for(var j=0;j<champs.length;j++) {
							td[j] =$("<td></td>");
						}
						td[0].text(sdata[i].libelle);
						td[1].text(sdata[i].quantite);
						td[2].text(sdata[i].prix_unitaire);
						td[3].text(sdata[i].total);

						var img = $('<span><span/>');img.addClass('uk-icon uk-icon-image item-img');
						img.attr('uk-icon-image','ratio:2');
						img.attr('id',sdata[i].photo);

						// td[4].append(img);
						for(var j=0;j<champs.length;j++) {
							list[i].append(td[j]);
						}
						// console.log(list[i]);
						table.append(list[i]);
					}
					$("td:empty").remove();


		 	//

		 };
$adminPage.getListCommand = function (formToken,url,reference,opt=true) {
// RECUPERATION DE LA LISTE DES COMMANDES
	var form = $adminPage.makeForm(formToken,url,reference);
	form.on('submit',function (e) {
		e.preventDefault();
		$.ajax({
			url : $(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType : 'json'
		})
		.done(function (data) {
			console.log(data);
			$adminPage.createTableDataCommand(data,['code','date','boutique','status','cash',''],$("#list-command"),opt);
		})
		.fail(function (data) {
			alert(data.responseJSON.message)
			$(location).attr('href','')
		});
	});
	form.submit();
};
//

$adminPage.createTableDataCommand = function (sdata,champs=null,table,opt=true) {
		 	//
		 	table.html('');
		 	var list=[];
					for(var i=0;i<sdata.length;i++) {
						var td=[]
						list[i]=$("<tr></tr>");
						for(var j=0;j<champs.length;j++) {
							td[j] =$("<td></td>");
						}
						td[0].text(sdata[i].code_command);
						td[1].text(sdata[i].date);
						td[2].text(sdata[i].boutique);
						var badge = $("<span></span>");
						if(sdata[i].status =="attente") {
							badge.addClass('uk-label uk-label-danger');
						} else {
							badge.addClass('uk-label uk-label-success');
						}

						badge.text(sdata[i].status);
						td[3].append(badge);
						// td[4].addClass('uk-text-right');
						td[4].append(sdata[i].cash);
						var details = $("<a></a>"); details.text('details');
						details.attr('href','command/'+sdata[i].code_command);
						if(!opt) {
							details.attr('href',sdata[i].code_command);
						}

						td[5].append(details);
						for(var j=0;j<champs.length;j++) {
							list[i].append(td[j]);
						}
						table.append(list[i]);
					}
					$("td:empty").remove();

		 };
$adminPage.getListCommandFilter = function (formToken,url,reference) {
	var form = $adminPage.makeForm(formToken,url,reference);

	form.on('submit',function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType: 'json'
		})
		.done(function (data) {
			console.log(data);
			$adminPage.createTableDataCommand(data,['code','date','boutique','status','cash',''],$("#list-command"));
		})
		.fail(function (data) {
			console.log(data);
		});
	});
	form.submit();
};

$adminPage.finaliseCommand = function (formToken,url,reference) {
	$(".btn-confirm").on('click',function() {
		var form = $adminPage.makeForm(formToken,url,reference);
		var input =$('<input/>');
		input.attr('type','hidden');
		 input.val($(this).attr('id'));
		input.attr('name','action');
		form.append(input);
		form.on('submit',function (e) {
			e.preventDefault();
			// envoi de la requete ajax
			$.ajax({
				url: $(this).attr('action'),
				type : $(this).attr('method'),
				data : $(this).serialize(),
				dataType:'json'
			})
			.done(function(data) {
				UIkit.modal.alert(data).then(function () {
					$(location).attr('href','');
				});
			})
			.fail(function(data) {
				console.log(data);
			});
		});
		form.submit();
	});
};

// RECHERCHE RAPIDE DES PRODUITS
$adminPage.findItem = function (formToken,url,reference,wordSearch) {
	var form = $adminPage.makeForm(formToken,url,reference);
	var input = $('<input/>'); input.attr('type','hidden'); input.attr('name','wordSearch');
	if(wordSearch) {
		input.val(wordSearch);
	}

	form.append(input);
	form.on('submit',function(e) {
		e.preventDefault();
		// envoi de la requet ajax
		$.ajax({
			url : $(this).attr('action'),
			type : $(this).attr('method'),
			data : $(this).serialize(),
			dataType : 'json'
		})
		.done(function (data) {
			if(data && data == "undefined") {
				$("#list-item").html("<h1>Not found</h1>");
			} else {
				$adminPage.createTableRow(data,['libelle','quantite','prix_achat','prix_unitaire','photo','edit','details'],$("#list-item"));
				$adminPage.showImage();
			}
		})
		.fail(function (data) {
			console.log(data);
		});
	});
	form.submit();
};
// ===

// FILTRER LES COMMANDES PAR DATE
$adminPage.filterByDate = function ($ref) {
	// FILTRAGE PAR DATE
		var bout = $("<input/>");
		 bout.attr('type','hidden');
		 bout.attr('name','ref');
		 bout.val($ref);
		$("#filter-date").append(bout);

		$("#filter-date").on('submit',function (e) {
			e.preventDefault();
			$.ajax({
				url : $(this).attr('action') ,
				type : $(this).attr('method'),
				data : $(this).serialize(),
				dataType : 'json'
			})
			.done(function (data) {
				console.log(data);
				$adminPage.createTableDataCommand(data,['code','date','boutique','status','cash',''],$("#list-command"),true);
			})
			.fail(function (data) {
				console.log(data);
			});
		});
};
