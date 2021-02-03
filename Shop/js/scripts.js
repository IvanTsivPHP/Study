'use strict';

const $_GET = {min: 350, max: 32000};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
  function decode(s) {
    return decodeURIComponent(s.split("+").join(" "));
  }

  $_GET[decode(arguments[1])] = decode(arguments[2]);
});

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      document.querySelector('.custom-form__price').textContent = document.querySelector('.custom-form__raw-price').textContent


      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      $.post("/phpJs/priceCalc.php", {price: document.querySelector('.custom-form__raw-price').textContent})
          .done(function (data) {
            document.querySelector('.custom-form__price').textContent = data;
          })

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });

};

const filterWrapper = document.querySelector('.filter__list');

if (filterWrapper) {


  filterWrapper.addEventListener('click', evt => {
    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}




const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {


    const prod = evt.path || (evt.composedPath && evt.composedPath());

    const itemId = prod[0].firstElementChild.textContent;

    const itemPrice = prod[0].children[3].textContent;


    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      document.querySelector('.custom-form__price').textContent = itemPrice;
      document.querySelector('.custom-form__raw-price').textContent = itemPrice;

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');

      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));
        inputs.forEach(inp => {
          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault();

          toggleHidden(shopOrder, popupEnd);

          popupEnd.classList.add('fade');
          setTimeout(() => popupEnd.classList.remove('fade'), 1000);

          window.scroll(0, 0);

          const buttonEnd = popupEnd.querySelector('.button');

          buttonEnd.addEventListener('click', () => {


            popupEnd.classList.add('fade-reverse');

            setTimeout(() => {

              popupEnd.classList.remove('fade-reverse');

              toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));
              $.post("/phpJs/orderCreation.php", {
                delivery: $('input[name=delivery]:checked').val(),
                id: itemId,
                name: $('input[name=name]').val(),
                surname: $('input[name=surname]').val(),
                thirdName: $('input[name=thirdName]').val(),
                phone: $('input[name=phone]').val(),
                email: $('input[name=email]').val(),
                city: $('input[name=city]').val(),
                street: $('input[name=street]').val(),
                home: $('input[name=home]').val(),
                aprt: $('input[name=aprt]').val(),
                pay: $('input[name=pay]:checked').val(),
                comment: $('textarea[name=comment]').val(),
                price: $('.custom-form__price').text(),
              })
                  .done(function () {
                    location.reload();
                  })

            }, 1000);

          });

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      const status = evt.target.previousElementSibling;

      if (status.classList && status.classList.contains('order-item__info--no')) {
        status.textContent = 'Выполнено';


      } else {
        status.textContent = 'Не выполнено';
      }
      const id = (evt.target.parentElement.parentElement.parentElement.getElementsByClassName('order-item__info--id')[0].innerHTML)
      $.post("/phpJs/changeStatus.php", {id: id, status: status.textContent})
      status.classList.toggle('order-item__info--no');
      status.classList.toggle('order-item__info--yes');

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {



  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');


  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);

    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });


  const button = document.querySelector('.button');
  const popupEnd = document.querySelector('.page-add__popup-end');
  const test =  window.location.search;


  button.addEventListener('click', (evt) => {
    $('#uploadForm').ajaxSubmit({
      type: 'POST',
      url: '/phpJs/uploadProducts.php',
      success: function(data) {
        if (data == 0) {
          form.hidden = true;
          popupEnd.hidden = false;
        } else {
          alert(data)
        }
      },
    });
    evt.preventDefault();



  })
  if (addList.querySelector('.add-list__item--active')) {
    addList.querySelector('.add-list__item--active').addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);

    });
  }
}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {

      $.post("/phpJs/deleteProduct.php", {id: target.name})
          .done(function () {
            productsList.removeChild(target.parentElement);
      })
    }
  });
}

// jquery range maxmin
if (document.querySelector('.shop-page')) {

  $('.range__line').slider({
    min: 350,
    max: 32000,
    values: [$_GET["min"], $_GET["max"]],
    range: true,
    stop: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
      $('input[name=min]').val($('.range__line').slider('values')[0]);
      $('input[name=max]').val($('.range__line').slider('values')[1]);


    },
    slide: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    }
  });
  document.querySelector('.range__line').addEventListener('mousedown', evt => {

  })
}
if (document.querySelector('.custom-form__select')) {
  $(".shop__sorting").change(function () {
    $(".button").trigger('click');

  })
}


/*

 */
