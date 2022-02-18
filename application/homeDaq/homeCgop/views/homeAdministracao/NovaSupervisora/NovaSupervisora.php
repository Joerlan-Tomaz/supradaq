<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nova Supervisora</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaHome()">Início</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);" onclick="rotaCgcont()">CGCONT</a></li>
                    <li class="breadcrumb-item active">Nova Supervisora</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <form method="post" name="formNovaSupervisora" id="formNovaSupervisora">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome_novaSupervisora" name="nome_novaSupervisora">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="button" class="btn btn-primary" onclick="insereNovasupervisora()">Inserir Supervisora</button>
                            </div>
                        </div>
                    </div>                  
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table id="tblNovaSupervisora" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 60%">Supervisora</th>
                                    <th style="width: 20%">Última Alteração</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>                               
                        </table>   
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</section>
