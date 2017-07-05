var stripe = Stripe('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
var elements = stripe.elements();

var card = elements.create('card', {
    style: {
        base: {
            iconColor: '#666EE8',
            color: '#31325F',
            lineHeight: '40px',
            fontWeight: 300,
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSize: '15px',

            '::placeholder': {
                color: '#CFD7E0',
            },
        },
    }
});
card.mount('#card-element');

card.on('change', function(event) {
    setOutcome(event);
});

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    document.querySelector('#pay-button').disabled = true;
    var initialSubmitText = document.querySelector('#pay-button').textContent;
    document.querySelector('#pay-button').textContent = "Processing...";

    var form = document.querySelector('form');
    var extraDetails = {
        name: form.querySelector('input[name=cardholder-name]').value,
    };

    //process it
    stripe.createToken(card, extraDetails).then( function(result) {

        var errorElement = document.querySelector('.error');
        errorElement.classList.remove('visible');

        if (result.token) {

            form.querySelector('input[name=stripeToken]').value = result.token.id;
            form.submit();

        } else if (result.error) {
            errorElement.textContent = result.error.message;
            errorElement.classList.add('visible');

            document.querySelector('#pay-button').disabled = false;
            document.querySelector('#pay-button').textContent = initialSubmitText;

        }

    });
});