var obNum = {
  count: function(name) {
      var id = document.getElementsByClassName(name).length;
      return id++;
  }
}

// Add new menu row to form.
function addMenuRow() {

  var div = document.createElement("div");
  div.className= 'menu_obj';
  div.id = 'ob_'+ obNum.count('menu_obj') +'';
  div.innerHTML= `
      <input type="text" name="menu[`+ obNum.count('menu_obj')  +`][name]" placeholder="Menu Name" required>
      <input type="text" name="menu[`+obNum.count('menu_obj')  +`][path]" placeholder="Menu Path" required>
      <div class="order-adjust">
        <input type="hidden" class="obj_order" name="menu[`+ obNum.count('menu_obj')  +`][weight]" value="`+ obNum.count('menu_obj') +`">
        <div class="link" title="up" onclick="moveRow(`+ obNum.count('menu_obj') + `, 'up');"><i class="fas fa-chevron-up"></i></div>
        <div class="link" title="down" onclick="moveRow(`+ obNum.count('menu_obj') + `, 'down');"><i class="fas fa-chevron-down"></i></div>
      </div>
      <span class="x" onclick="removeMenu('ob_`+ obNum.count('menu_obj') +`');"><i class="fas fa-ban"></i></span>
      `;
  document.getElementById('menu_well').appendChild(div);
}

// Remove Menu Item
function removeMenu(id) {
  document.getElementById(id).outerHTML = "";
}

function moveRow(rowNum, direction) {

  const num = Number(rowNum);
  const currentRow = document.getElementById('ob_' + num);
  const rowCurrentOrder = currentRow.getElementsByClassName('obj_order')[0].value;

  if (direction == 'down') {
    const rowBelowId = currentRow.nextElementSibling.id;
    const rowBelow = document.getElementById(rowBelowId);
    const rowBelowOrder = rowBelow.getElementsByClassName('obj_order')[0].value;
    
    // Change current row order with that of the one below
    currentRow.getElementsByClassName('obj_order')[0].value = rowBelowOrder;

    // Move current row down
    currentRow.before(rowBelow);

    // On move down we then need to append the item up with the previous current row weight.
    rowBelow.getElementsByClassName('obj_order')[0].value = rowCurrentOrder;

  }

  if (direction == 'up') {
    if (currentRow.previousElementSibling.id) {}
    const rowAboveId = currentRow.previousElementSibling.id;
    const rowAbove = document.getElementById(rowAboveId);
    const rowAboveOrder = rowAbove.getElementsByClassName('obj_order')[0].value;

      // Change current row order with that of the one below
      currentRow.getElementsByClassName('obj_order')[0].value = rowAboveOrder;

      // Move current row down
      currentRow.after(rowAbove);

      // On move down we then need to append the item up with the previous current row weight.
      rowAbove.getElementsByClassName('obj_order')[0].value = rowCurrentOrder;
  }
}