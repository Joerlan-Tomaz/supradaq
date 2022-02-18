<script src="<?php echo(base_url('application/homeDaq/homeCgob/assets/js/supervisaodaq/sicro/sicrosupervisoraView.js')) ?>" type="text/javascript"></script> 	
<div class="content-wrapper" >

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Relação SICRO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Relação SICRO</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default">
                <div class="card-header">
                    <form method="post" name="formulario">
                        <h6>                            
                            Relação de equipamentos,pessoal,materiais e serviços contidos no SICRO.
<!--							<div class='ocultar'><u>[+/-] Leia mais...</u></div>-->
                            <div class='mostrar'>
                                
                            </div>
                        </h6>
                       
                    </form>
                </div>

                <div class="card-body">
                    <!-- cadastrar novos itens -->
                    <div class="row" id="cadastraritens">
                        <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Selecione o item</label>
                                <select class="form-control" name="itemcadastro" id="itemcadastro" required></select>                                        
                            </div> 
                        </div>
                        <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Código Sicro</label>
                                <input class="form-control" type="text" name="sicro" id="sicro"  >                                       
                            </div> 
                        </div>
                         <div class="col-md-3" >  
                            <div class="form-group">
                                <label>Tipo</label>
                                <input class="form-control" type="text" name="tipo" id="tipo" >                                         
                            </div> 
                        </div>
                    </div> 
                    <div class="row" id="tableitens">   
                        <div class="col-md-12 table-responsive" style="font-size: small">
                            <table id="tablecadastraritem" class="table table-striped width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 26px;">#</th>
                                        <th style="width: 115px;">Item</th>
                                        <th style="width: 72px;">Código Sicro</th>
                                        <th style="width: 396px;">Tipo</th>
                                        <th style="width: 52px;">Unidade</th> 
                                        <th style="width: 55px;">Cadastrar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>                               
                            </table>     
                        </div>	
                    </div>    
                   
                    <!-- fim -->
                   
                   


                </div> 
            </div>
        </div>
    </section>
    <!-- /.content -->

</div>
