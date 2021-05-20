var obNum = {
  count: function(name) {
      var id = document.getElementsByClassName(name).length;
      return id++;
  }
}

// Add new User row to form.
function addUserRow() {

  var div = document.createElement("div");
  div.className= 'user_obj';
  div.id = 'ob_'+ obNum.count('user_obj') +'';
  div.innerHTML= `
      <input type="text" name="user[`+ obNum.count('user_obj')  +`]" placeholder="Email Address" required>
      <span class="x" onclick="removeUser('ob_`+ obNum.count('user_obj') +`');"><i class="fas fa-ban"></i></span>
      `;
  document.getElementById('user_well').appendChild(div);
}

// Remove cat Item
function removeUser(id) {
  document.getElementById(id).outerHTML = "";
}