<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ponto</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    /* Estilos adicionais para o modal de carregamento */
    .modal {
      display: none; /* Inicia oculto */
      position: fixed;
      z-index: 9999;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 300px; /* Ajuste a largura do modal */
    }

    .modal-text {
      text-align: center;
      color: #333;
    }

    .hidden-content {
      display: none;
    }
  </style>
</head>
<body class="h-screen min-w-screen hidden-content">




<div class="h-screen min-w-screen flex items-center justify-center bg-gray-100">
    <div class="rounded-lg flex flex-col items-center justify-center bg-blue-800 h-4/5 w-3/5">
      <form class="flex flex-col" id="saveForm">
        <input
          pattern="[0-9]*"
          class="mb-2 px-8 py-2 text-center border border-gray-300"
          type="text"
          placeholder="Código"
          name="codigo"
          id="codigo"
          required
        />
        <div class="mt-10 flex items-center justify-center">
          <button class="btn btn-dark px-5" type="submit">
            Salvar
          </button>
        </div>
      </form>

      <div id="loading" class="modal">
        <div class="modal-content">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-gray-900"></div>
          <div class="modal-text mt-4">Carregando...</div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function checkScreenSize() {
      const width = window.innerWidth;
      const height = window.innerHeight;
      if ((width === 800 && height === 475 ) || (width === 1920 && height === 953) ) {
        document.body.classList.remove('hidden-content');
      } else {
        document.body.classList.add('hidden-content');
      }
    }

    function setFocusAndClear() {
      const codigoInput = document.getElementById('codigo');
      codigoInput.value = '';
      codigoInput.focus();
    }

    window.addEventListener('load', () => {
      checkScreenSize();
      setFocusAndClear();
    });

    window.addEventListener('resize', checkScreenSize);

    document.getElementById('saveForm').addEventListener('submit', async function(event) {
      event.preventDefault();

      const codigo = document.getElementById('codigo').value;
      const loadingElement = document.getElementById('loading');
      loadingElement.style.display = 'block'; // Mostrar o modal de carregamento

      try {
        const response = await fetch('/salvar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content, // Obter o token CSRF do cabeçalho
          },
          body: JSON.stringify({ codigo: codigo }),
        });

        loadingElement.style.display = 'none'; // Esconder o modal de carregamento

        if (response.ok) {
          const result = await response.json();
          if (result.id) {
            Swal.fire({
              icon: 'success',
              title: 'Ponto Registrado',
              timer:3000,
              text: `${result.Nome} - ${result.Data} - ${result.Hora} `
            });
          } else {
            Swal.fire({
              icon: 'info',
              title: 'Mensagem',
              text: result.message
              
            });
          }
        } else {
          const result = await response.json();
          Swal.fire({
            icon: 'warning',
            timer:3000,
            text: 'Você já assinou todos os pontos de hoje.'
          });
        }
      } catch (error) {
        loadingElement.style.display = 'none'; // Esconder o modal de carregamento em caso de erro
        console.error('Erro:', error);
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          timer:3000,
          text: error.message
        });
      } finally {
        setFocusAndClear();
      }
    });
  </script>
</body>
</html>
