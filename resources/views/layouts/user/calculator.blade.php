<div class="card mb-0">
    <div class="card-body">
        <input type="text" class="form-control mb-3" id="result" disabled placeholder="0">
        <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('7')">7</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('8')">8</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('9')">9</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="appendValue('*')">*</button>
            </div>

            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('4')">4</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('5')">5</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('6')">6</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="appendValue('-')">-</button>
            </div>

        </div>
        <div class="row">

            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('1')">1</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('2')">2</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('3')">3</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="appendValue('+')">+</button>
            </div>

            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="clearValue()">C</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="appendValue('.')">.</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2 number" onclick="appendValue('0')">0</button>
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-primary btn-block mb-2" onclick="appendValue('/')">/</button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-block btn-secondary h2 py-0 btn-calculate" onclick="calculate()">=</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize global variables
    let currentValue = '';
    let previousValue = '';
    let operator = '';

    // Append value to the input field
    function appendValue(value) {
        currentValue += value;
        $('#result').val(currentValue);
    }

    // Clear the input field
    function clearValue() {
        currentValue = '';
        previousValue = '';
        operator = '';
        $('#result').val('0');
    }

    // Perform the calculation
    function calculate() {
        try {
            // Use eval to calculate result
            currentValue = eval(currentValue);
            // Display the result
            $('#result').val(currentValue);
            // Reset variables
            previousValue = '';
            operator = '';
        } catch (error) {
            // Handle errors (e.g., division by zero)
            $('#result').val('Error');
        }
    }

    // Add event listener to clear button
    $('.btn-clear').on('click', clearValue);

    // Add event listeners to number and operator buttons
    $('.number, .operator').on('click', function() {
        if ($(this).hasClass('operator')) {
            // If an operator is clicked, set the operator and previous value
            operator = $(this).text();
            previousValue = currentValue;
            currentValue = '';
        } else {
            // If a number is clicked, append the value
            appendValue($(this).text());
        }
    });
</script>
