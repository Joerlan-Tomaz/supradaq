<section id="controle_pluviometrico_resumo_eclusa" class="sheet padding-10mm">
		
		
		
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fullJustify table-responsive">
				<table class="tabela bordaCompleta" style=" width: 100%;">
					<tbody>
					<tr>
						<td colspan="12">
							<br>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table class="bordaCompleta center tabela" style=" width: 100%;">
                                                                <?php    foreach($fluviometrico_resumo_eclusa as $controleFluv){ 
									 echo $controleFluv['tabela']; 
                                                                } ?>                 
								</table>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="  margin: 2% 0%;">
								Convenção: <br>
								<table class="bordaCompleta center tabela" style=" width: 40%;">
									<tr class="centerBold">
										<td>CONDIÇÃO</td>
										<td>LEGENDA - LETRA</td>
									</tr>
									<tr class="pluviometricoSP">
										<td>SEM PREENCHIMENTO</td>
										<td style='background-color: #DCDCDC'>SP</td>
									</tr>
									<tr class="pluviometricoB">
										<td>Em Operação</td>
										<td style='background-color: #33fd33'>OP</td>
									</tr>
									<tr class="pluviometricoI">
										<td>Fora de Operação</td>
										<td style='background-color: #fb3a3a'>FO</td>
									</tr>
									<tr class="pluviometricoNA">
										<td>Não Aplicável</td>
										<td style='background-color: #9e9e9e'>N/A</td>
									</tr>
								</table>
							</div>
							
						</td>
					</tr>
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
        