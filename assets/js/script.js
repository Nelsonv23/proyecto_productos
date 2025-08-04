document.addEventListener("DOMContentLoaded", function () {
  const bodegaSelect = document.getElementById("bodega");
  const sucursalSelect = document.getElementById("sucursal");
  const monedaSelect = document.getElementById("moneda");

  // URL principal
  const BASE_URL = "/Desis";

  // Cargar select Bodegas
  fetch(BASE_URL + "/controllers/loadBodegas.php")
    .then((r) => r.json())
    .then((data) => {
      if (data.success && Array.isArray(data.bodegas)) {
        data.bodegas.forEach((bodega) => {
          const opt = document.createElement("option");
          opt.value = bodega.id;
          opt.textContent = bodega.nombre;
          bodegaSelect.appendChild(opt);
        });
      }
    })
    .catch((err) => {
      console.error("Error cargar bodegas:", err);
      alert("Error al cargar bodegas.");
    });

  // Cargar select Monedas
  fetch(BASE_URL + "/controllers/loadMonedas.php")
    .then((r) => r.json())
    .then((data) => {
      if (data.success && Array.isArray(data.monedas)) {
        data.monedas.forEach((moneda) => {
          const opt = document.createElement("option");
          opt.value = moneda.id;
          opt.textContent = moneda.nombre;
          monedaSelect.appendChild(opt);
        });
      }
    });

  // Cargar Sucursales cuando cambia la Bodega
  bodegaSelect.addEventListener("change", function () {
    const bodegaId = this.value;
    sucursalSelect.innerHTML = '<option value=""></option>';

    if (!bodegaId) return;

    fetch(BASE_URL + "/controllers/loadSucursales.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "bodega_id=" + bodegaId,
    })
      .then((r) => r.json())
      .then((data) => {
        if (data.success && Array.isArray(data.sucursales)) {
          data.sucursales.forEach((s) => {
            const opt = document.createElement("option");
            opt.value = s.id;
            opt.textContent = s.nombre;
            sucursalSelect.appendChild(opt);
          });
        }
      });
  });

  // Validación y Envío del Formulario
  document
    .getElementById("productForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const codigo = document.getElementById("codigo").value.trim();
      if (!codigo)
        return alert("El código del producto no puede estar en blanco.");
      if (!/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{5,15}$/.test(codigo)) {
        if (!/[a-zA-Z]/.test(codigo))
          return alert("El código del producto debe contener letras y números");
        if (!/\d/.test(codigo))
          return alert("El código del producto debe contener letras y números");
        return alert(
          "El código del producto debe tener entre 5 y 15 caracteres."
        );
      }

      const nombre = document.getElementById("nombre").value.trim();
      if (!nombre)
        return alert("El nombre del producto no puede estar en blanco.");
      if (nombre.length < 2 || nombre.length > 50)
        return alert(
          "El nombre del producto debe tener entre 2 y 50 caracteres."
        );

      const bodega = bodegaSelect.value;
      if (!bodega) return alert("Debe seleccionar una bodega.");

      const sucursal = sucursalSelect.value;
      if (!sucursal)
        return alert(
          "Debe seleccionar una sucursal para la bodega seleccionada."
        );

      const moneda = monedaSelect.value;
      if (!moneda)
        return alert("Debe seleccionar una moneda para el producto.");

      const precio = document.getElementById("precio").value.trim();
      if (!precio)
        return alert("El precio del producto no puede estar en blanco.");
      if (!/^\d+(\.\d{1,2})?$/.test(precio))
        return alert(
          "El precio del producto debe ser un número positivo con hasta dos decimales."
        );

      const materiales = document.querySelectorAll(
        'input[name="material[]"]:checked'
      );
      if (materiales.length < 2)
        return alert(
          "Debe seleccionar al menos dos materiales para el producto."
        );

      const descripcion = document.getElementById("descripcion").value.trim();
      if (!descripcion)
        return alert("La descripción del producto no puede estar en blanco.");
      if (descripcion.length < 10 || descripcion.length > 1000)
        return alert(
          "La descripción del producto debe tener entre 10 y 1000 caracteres."
        );

      // Verificar unicidad del código
      fetch(BASE_URL + "/controllers/checkCodigo.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "codigo=" + encodeURIComponent(codigo),
      })
        .then((r) => r.json())
        .then((data) => {
          if (data.exists) {
            alert("El código del producto ya está registrado.");
            return;
          }

          const formData = new FormData(this);
          fetch(BASE_URL + "/controllers/ProductController.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => {
              const contentType = response.headers.get("content-type");
              if (!contentType || !contentType.includes("application/json")) {
                return response.text().then((text) => {
                  console.error("Respuesta no es JSON:", text);
                  throw new Error(
                    "El servidor no devolvió JSON. Revisa el archivo PHP."
                  );
                });
              }
              return response.json();
            })
            .then((res) => {
              if (res.success) {
                alert("Producto guardado exitosamente.");
                this.reset();
                sucursalSelect.innerHTML =
                  '<option value="">Seleccionar Sucursal</option>';
              } else {
                alert("Error: " + res.message);
              }
            })
            .catch((error) => {
              console.error("Error en el envío:", error);
              alert("Error técnico. Revisa la consola.");
            });
        });
    });
});
