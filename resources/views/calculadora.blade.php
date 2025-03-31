<x-layout>
    @section('title', 'calculadora')

    @section('content')
    <style>

        .calculator {
            background-color: rgb(17 24 39);

            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 1100px;
        }
    }
        .calculator {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 260px;
        }
        .screen {
            background: #333;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            text-align: right;
            font-size: 2rem;
            margin-bottom: 10px;
            min-height: 60px;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .button {
            background: #e4e4e4;
            border: none;
            padding: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }
        .button:active {
            background-color: #ccc;
        }
        .button-operator {
            background: #f5a623;
            color: white;
        }
        .button-operator:active {
            background-color: #f28c22;
        }
        .button-equal {
            background: #4caf50;
            color: white;
        }
        .button-equal:active {
            background-color: #45a049;
        }
        .button-clear {
            background: #f44336;
            color: white;
        }
        .button-clear:active {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="calculator">
        <div class="screen" id="screen">0</div>
        <div class="buttons">
            <button class="button button-clear" onclick="clearScreen()">C</button>
            <button class="button button-operator" onclick="appendToScreen('/')">/</button>
            <button class="button button-operator" onclick="appendToScreen('*')">*</button>
            <button class="button button-operator" onclick="appendToScreen('-')">-</button>

            <button class="button" onclick="appendToScreen('7')">7</button>
            <button class="button" onclick="appendToScreen('8')">8</button>
            <button class="button" onclick="appendToScreen('9')">9</button>
            <button class="button button-operator" onclick="appendToScreen('+')">+</button>

            <button class="button" onclick="appendToScreen('4')">4</button>
            <button class="button" onclick="appendToScreen('5')">5</button>
            <button class="button" onclick="appendToScreen('6')">6</button>
            <button class="button-equal" onclick="calculate()">=</button>

            <button class="button" onclick="appendToScreen('1')">1</button>
            <button class="button" onclick="appendToScreen('2')">2</button>
            <button class="button" onclick="appendToScreen('3')">3</button>
            <button class="button" onclick="appendToScreen('0')">0</button>

            <button class="button" onclick="appendToScreen('.')">.</button>
        </div>
    </div>

    <script>
        // Funciones de la calculadora
        function clearScreen() {
            document.getElementById('screen').textContent = '0';
        }

        function appendToScreen(value) {
            const screen = document.getElementById('screen');
            if (screen.textContent === '0') {
                screen.textContent = value;
            } else {
                screen.textContent += value;
            }
        }

        function calculate() {
            const screen = document.getElementById('screen');
            try {
                screen.textContent = eval(screen.textContent);
            } catch (e) {
                screen.textContent = 'Error';
            }
        }

        // Función para escuchar las teclas del teclado
        document.addEventListener('keydown', function(event) {
            const key = event.key;

            if (key >= '0' && key <= '9') {  // Si es un número
                appendToScreen(key);
            } else if (key === '/' || key === '*' || key === '-' || key === '+') {  // Si es un operador
                appendToScreen(key);
            } else if (key === 'Enter' || key === '=') {  // Si es igual
                calculate();
            } else if (key === 'Backspace') {  // Si es la tecla de borrar
                clearScreen();
            } else if (key === '.') {  // Si es el punto decimal
                appendToScreen('.');
            }
        });
    </script>
</body>
@endsection
</x-layout>

