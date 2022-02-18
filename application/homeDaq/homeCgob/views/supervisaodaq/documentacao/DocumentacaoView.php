<script src="<?php echo(base_url(''))?>" type="text/javascript"></script> 
 <style>
.mailbox-attachment-icon {
    background:#f4f6f9;
    color:#015175;
}

.mailbox-attachment-info {
    padding: 20px;
    background: transparent;
}

.mailbox-attachments li {
    margin-right: 0px;
    width: 100%;
    border: 1px solid #dbdbdb;
    min-height: 250px;
}

.btn-pushmenu{
    display: none !important;
}
</style>    
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Documentação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">DAQ</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaInfoContrato()"><?php echo $this->session->numero_contrato ?></a></li>
                        <li class="breadcrumb-item active">Documentação</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

   <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <small class="text-muted"></small>
                </div>
            </div><br>
<!-- 
            <div class="card">   
                <div class="card-body">
                    <ul class="mailbox-attachments clearfix row">


                        <div class="col-md-3">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a  class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>Manual do Usuário - SUPRA AQUAVIÁRIO</a>
                                    <span class="mailbox-attachment-size">
                                        
                                        <a  class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        </div>
                        <div class="col-md-3">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a  class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>Instrução de Serviços - SUPRA AQUAVIÁRIO</a>
                                    <span class="mailbox-attachment-size">
                                        
                                        <a  class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        </div>

                        <div class="col-md-3">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a  class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>Memorando Circular - SUPRA AQUAVIÁRIO</a>
                                    <span class="mailbox-attachment-size">
                                        
                                        <a  class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        </div>

                        <div class="col-md-3">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a  class="mailbox-attachment-name"><i class="fa fa-paperclip"></i>Apresentações - SUPRA AQUAVIÁRIO</a>
                                    <span class="mailbox-attachment-size">
                                        
                                        <a  class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                                </div>
                            </li>
                        </div>
                        <div class="col-md-3">
                            <li>
                                <span class="mailbox-attachment-icon"><i class="fa fa-video-camera"></i></span>

                                <div class="mailbox-attachment-info">
                                    <a data-toggle="modal" href="#myVideo" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Tutorial - SUPRA AQUAVIÁRIO</a>
                                    <span class="mailbox-attachment-size">
                                        Clique para assistir
                                        <a data-toggle="modal" href="#myVideo" class="btn btn-default btn-sm float-right">Assistir</a>
                                    </span>
                                </div>
                            </li>
                        </div>
                    </ul>
                </div>
        

            </div> -->
        </div>
        
    </section>
</div>
