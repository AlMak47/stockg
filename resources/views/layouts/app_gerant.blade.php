@extends('layouts.template')

@section('content')
@yield('gerant_contents')
<div id="loader" uk-spinner></div>
<div id="panier-content" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Command en Attente de confirmation</h2>
        </div>
        <div class="uk-modal-body">
        	<table class="uk-table " >
        		<thead>
			        <tr>
			            <th>Item</th>
			            <th>Quantite</th>
			            <th>Pu(GNF)</th>
			            <th>Total</th>
			        </tr>
			    </thead>
			    <tbody id="details-panier">
                    <div id="load" uk-spinner></div>
                </tbody>
        	</table>
            <div class="uk-h2"><span>TOTAL RECU (GNF)= </span><span id="cash"></span> </div>
        </div>
        <div class="uk-modal-footer">
        	<!-- ENVOI DE LA CONFIRMATION DE LA COMMANDE EN ATTENTE -->
            <a class="uk-button uk-button-default btn-confirm" id="abort"><span uk-icon="icon:close"></span> Annuler</a>
        	<a class="uk-button uk-button-default btn-confirm" id="confirm"><span uk-icon="icon:check"></span> Confirmer</a>
        </div>
    </div>
</div>
@endsection

@section('script') 
<script type="text/javascript">
	
	$(function () {
		// $adminPage.getPanier("{{csrf_token()}}","{{url()->current()}}/"+"get-panier");
        // $adminPage.finaliseCommand("{{csrf_token()}}","command/finalise","");
        $(document).ajaxSuccess(function () {
            $("#loader").hide();
        });

	});

</script>
@yield('gerant_script')
@endsection