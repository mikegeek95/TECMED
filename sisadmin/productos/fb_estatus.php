<article class="module">

		<header>

			<h3 class="tabs_involved">Buscar Producto por Estatus</h3>

           <!-- <ul class="tabs">

                <li><a href="#" onClick="aparecermodulos('productos/fa_productos.php','main');">Agregar Productos</a></li>

			</ul>-->

		</header>

		

        <div class="module_content">

        

        <fieldset>

        <form action="#" id="bu_estatus">

        <div style="width:300px; float:left; margin-right: 10px;">

                 <label for="estatus">Estatus</label> 

                 <select id="estatus">

                   <option value="1">Activo</option>

                   <option value="0">No Activo</option>

                 

                 

                 </select>

        </div>

        <div style="width:100px; float: right; margin-right: 40px;"><br/><br/>

                 <input name="btn_agregar" type="button" id="btn_guardar" value="Buscar" onclick="GuardarEspecial('bu_estatus','productos/bu_estatus.php','productos/fb_estatus.php','main');" />

        </div>

        </form>

        </fieldset>

        

        <fieldset>

        tabla

        </fieldset>

        

        </div>

        

        

       <!--    <footer>

      <div class="submit_link">

                    <input type="button" value="Guardar" onClick="aparecermodulos('productos/vi_productos.php','main');">



        </div>

		

            </footer>     -->

        

        

</article>