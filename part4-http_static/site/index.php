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
   <table id="data_table">
      <tr>
         <th>Name</th>
         <th>Catch phrase</th>
      </tr>
   </table>
</div>

<script>
   function generate() {
      let nb = document.getElementById("nb").value;

      let table = document.getElementById("data_table");
      let data_lines = document.querySelectorAll('.data_line');

      data_lines.forEach(line => {
         line.remove();
      });

      fetch("http://localhost/api?amount=" + nb)
         .then((response) => response.json())
         .then((data) => {
            data.forEach(d => {
               table.innerHTML += "<tr class=\"data_line\"><td>" + d.name + "</td><td>" + d.catch_phrase + "</td></tr>";
            });
         });
   }

   generate();
</script>