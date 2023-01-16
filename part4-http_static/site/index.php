<style>
   table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
   }
</style>

<h1>Hello</h1>
Ceci est la page de base du serveur http docker <b><?php echo $_SERVER['SERVER_ADDR']; ?></b>

<div>
   <h2>Générateur d'idée d'entreprise</h2>

   <label for="nb">Nombre à générer</label>
   <input type="number" id="nb" name="nb" value="20">
   <button onclick="generate()">Générer</button>
   <label for="auto_refresh">Actualisation auto (5s)</label>
   <input type="checkbox" id="auto_refresh" name="auto_refresh">
   <table>
      <thead>
         <tr>
            <th>Name</th>
            <th>Catch phrase</th>
         </tr>
      </thead>
      <tbody id="table_body">
      </tbody>
   </table>
</div>

<script>
   function generate() {
      let nb = document.getElementById("nb").value;

      let table_body = document.getElementById("table_body");
      table_body.innerHTML = "";

      fetch("http://localhost/api?amount=" + nb)
         .then((response) => response.json())
         .then((data) => {
            data.forEach(d => {
               table_body.innerHTML += "<tr class=\"data_line\"><td>" + d.name + "</td><td>" + d.catch_phrase + "</td></tr>";
            });
         });
   }

   generate();
   setInterval(() => {
      let auto_checkbox = document.getElementById("auto_refresh");
      if (!auto_checkbox.checked) return;

      generate();
   }, 5000);
</script>