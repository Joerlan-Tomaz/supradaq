<script src="<?php echo (base_url('assets/js/workshop/workshop.js')) ?>"></script>

<div class="content-wrapper" style="margin-left: 0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>2º WorkShop Supra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Home</a></li>
                        <li class="breadcrumb-item active">2º WorkShop Supra</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid" style=" text-align: left;">

			<form method="post" name="formularioWorkshop" id="formularioWorkshop">
				<div class="row">                   

					<div class="col-md-12">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" id="workshop_nome" name="workshop_nome" placeholder="Nome">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" id="workshop_email" name="workshop_email" placeholder="Email">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Telefone</label>
							<input type="text" class="form-control" id="workshop_telefone" name="workshop_telefone" placeholder="Telefone">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Orgão/Empresa</label>
							<input type="text" class="form-control" id="workshop_orgao" name="workshop_orgao" placeholder="Empresa/Orgão">
						</div>
					</div>

				</div>
			</form>

			<button type="button" class="btn btn-primary" onclick="gravaWorkshop()"  >Salvar</button>
			<hr>
			
			<div class="row">
				<div class="col-md-12" >
					<table id="tableWorkshop" class="table table-striped">
						<thead>
							<tr>
								<td>Nome</td>
								<td>Email</td>
								<td>Telefone</td>
								<td>Orgão/Empresa</td>
							</tr>
						</thead>
						<tbody>
						</tbody>                               
					</table>       
				</div>                  
			</div>

        </div>
    </section>

</div>

<footer>
    <img src="<?php echo (base_url('assets/img/logos_dnit_cinza_semfundo.png')) ?>"  width="30%" style="float: right; position: relative; right: 95px; margin: 5% 0 auto;">
</footer>