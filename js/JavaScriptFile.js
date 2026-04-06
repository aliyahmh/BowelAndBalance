// ingrediants

const page = location.pathname.toLowerCase(); // to know which page are we in

let addBtn = document.getElementById("bd-addIngre-btn"); // for adding more ingrediants
let list = document.getElementById("ingredients-list"); // this is the div in html of container of ingrediants

if (page.includes("addnewrecipe")) {

  // Add Ingredient Row
  function addIngredientRow() {
    let row = document.createElement("div"); // each row contains ingredient name and quantity
    row.className = "ingredient-row";
    row.innerHTML = `
      <input class="ing-name" type="text" name="ingredient_name[]" placeholder="Ingredient name">
      <input class="ing-qty" type="text" name="ingredient_quantity[]" placeholder="Quantity">
    `;
    list.appendChild(row);
  }

  // Only add a default row if there is no row already in HTML
  if (list && list.children.length === 0) {
    addIngredientRow();
  }

  if (addBtn) {
    addBtn.onclick = function () {

      const rows = document.getElementsByClassName("ingredient-row");
      const lastRow = rows[rows.length - 1];

      const nameInput = lastRow.getElementsByClassName("ing-name")[0];
      const qtyInput = lastRow.getElementsByClassName("ing-qty")[0];

      const name = nameInput.value.trim();
      const qty = qtyInput.value.trim();

      if (name == "") {
        alert("Ingredient name cannot be empty");
        nameInput.focus();
        return;
      }

      if (qty === "") {
        alert("Quantity cannot be empty");
        qtyInput.focus();
        return;
      }

      // prevent duplicate ingredient names
      const allNames = document.getElementsByClassName("ing-name");
      for (let i = 0; i < allNames.length - 1; i++) {
        if (allNames[i].value.trim().toLowerCase() === name.toLowerCase()) {
          alert("This ingredient is already added");
          nameInput.focus();
          return;
        }
      }

      addIngredientRow();
    };
  }

  // Instructions

  const addStepBtn = document.getElementById("bd-addStep-btn");
  const stepsList = document.getElementById("steps-list");

  function addStepRow() {
    const row = document.createElement("div");
    row.className = "step-row";
    row.innerHTML = `<textarea class="step-text" name="steps[]" placeholder="Write the step here..."></textarea>`;
    stepsList.appendChild(row);
  }

  // Only add a default row if there is no row already in HTML
  if (stepsList && stepsList.children.length === 0) {
    addStepRow();
  }

  if (addStepBtn) {
    addStepBtn.onclick = function () {

      const steps = document.getElementsByClassName("step-text");
      const lastStep = steps[steps.length - 1];

      if (lastStep.value.trim() === "") {
        alert("Step cannot be empty");
        lastStep.focus();
        return;
      }

      addStepRow();
    };
  }

  // Form submit validation (Add Recipe)

  const form = document.getElementById("bd-addRecipeForm");

  // Video Preview

  const videoFileInput = document.getElementById("bd-videoFile");
  const videoUrlInput = document.getElementById("bd-videoUrl");
  const videoPreview = document.getElementById("bd-videoPreview");

  // When user selects a video file
  if (videoFileInput && videoPreview) {
    videoFileInput.addEventListener("change", () => {
      const file = videoFileInput.files[0];
      if (!file) return;

      if (!file.type.startsWith("video/")) {
        alert("Please select a video file only");
        videoFileInput.value = "";
        videoPreview.style.display = "none";
        return;
      }

      if (videoUrlInput) videoUrlInput.value = "";

      const url = URL.createObjectURL(file);

      videoPreview.src = url;
      videoPreview.style.display = "block";
      videoPreview.load();
    });
  }

  // When user types a video URL
  if (videoUrlInput && videoPreview) {
    videoUrlInput.addEventListener("input", () => {
      const url = videoUrlInput.value.trim();

      if (url !== "" && videoFileInput) {
        videoFileInput.value = "";
      }

      if (url === "") {
        videoPreview.style.display = "none";
        videoPreview.removeAttribute("src");
        return;
      }

      videoPreview.src = url;
      videoPreview.style.display = "block";
      videoPreview.load();
    });
  }

  // Image Preview

  const photoInput = document.getElementById("bd-photoFile");
  const photoPreview = document.getElementById("bd-photoPreview");

  if (photoInput && photoPreview) {
    photoInput.addEventListener("change", () => {
      const file = photoInput.files[0];
      if (!file) return;

      if (!file.type.startsWith("image/")) {
        alert("Please select an image only");
        photoInput.value = "";
        photoPreview.style.display = "none";
        return;
      }

      const url = URL.createObjectURL(file);

      photoPreview.src = url;
      photoPreview.style.display = "block";
    });
  }

  if (form) {
    form.onsubmit = function (e) {

      // 1) Recipe name
      const recipeName = document.getElementById("bd-name");
      if (recipeName.value.trim() === "") {
        alert("Recipe name cannot be empty");
        recipeName.focus();
        e.preventDefault();
        return;
      }

      // 2) Description
      const desc = document.querySelector("#bd-description-div textarea");
      if (desc.value.trim() === "") {
        alert("Description cannot be empty");
        desc.focus();
        e.preventDefault();
        return;
      }

      // 3) Photo (required)
      const photoInput = document.getElementById("bd-photoFile");

      if (!photoInput || !photoInput.files || photoInput.files.length === 0) {
        alert("Photo is required");
        if (photoInput) {
          photoInput.focus();
        }
        e.preventDefault();
        return;
      }

      // 4) Ingredients
      const ingNames = document.getElementsByClassName("ing-name");
      const ingQtys = document.getElementsByClassName("ing-qty");

      for (let i = 0; i < ingNames.length; i++) {
        const n = ingNames[i].value.trim();
        const q = ingQtys[i].value.trim();

        if (n === "") {
          alert("Ingredient name cannot be empty");
          ingNames[i].focus();
          e.preventDefault();
          return;
        }

        if (q === "") {
          alert("Quantity cannot be empty");
          ingQtys[i].focus();
          e.preventDefault();
          return;
        }
      }

      // 5) Steps
      const steps = document.getElementsByClassName("step-text");
      for (let i = 0; i < steps.length; i++) {
        if (steps[i].value.trim() === "") {
          alert("Step cannot be empty");
          steps[i].focus();
          e.preventDefault();
          return;
        }
      }

      // Important:
      // Do not prevent form submission here.
      // Let the form submit normally to add_recipe_process.php
    };
  }
}

/* ------------------------------------------------------------------EditRecipe page---------------------------------------------------------------*/

if (page.includes("editrecipe")) {

  function addIngredientRow(name = "", quant = "") {
    let row = document.createElement("div");
    row.className = "ingredient-row";
    row.innerHTML = `
      <input class="ing-name" type="text" name="ingredient_name[]" placeholder="Ingredient name" value="${name}">
      <input class="ing-qty" type="text" name="ingredient_quantity[]" placeholder="Quantity" value="${quant}">
    `;
    list.appendChild(row);
  }

  addIngredientRow("Yogurt", "1cup");
  addIngredientRow("Mixed Berry", "1/2 cup");
  addIngredientRow("Honey / Maple Syrup", "1 tablespoon");
  addIngredientRow("Granola", "2 tablespoons");
  addIngredientRow("Mint leaves", "few leaves");

  if (addBtn) {
    addBtn.onclick = function () {

      const rows = document.getElementsByClassName("ingredient-row");
      const lastRow = rows[rows.length - 1];

      const nameInput = lastRow.getElementsByClassName("ing-name")[0];
      const qtyInput = lastRow.getElementsByClassName("ing-qty")[0];

      const name = nameInput.value.trim();
      const qty = qtyInput.value.trim();

      if (name == "") {
        alert("Ingredient name cannot be empty");
        nameInput.focus();
        return;
      }

      if (qty === "") {
        alert("Quantity cannot be empty");
        qtyInput.focus();
        return;
      }

      const allNames = document.getElementsByClassName("ing-name");
      for (let i = 0; i < allNames.length - 1; i++) {
        if (allNames[i].value.trim().toLowerCase() === name.toLowerCase()) {
          alert("This ingredient is already added");
          nameInput.focus();
          return;
        }
      }

      addIngredientRow();
    };
  }

  // Instructions

  const addStepBtn = document.getElementById("bd-addStep-btn");
  const stepsList = document.getElementById("steps-list");

  function addStepRow(stp = "") {
    const row = document.createElement("div");
    row.className = "step-row";
    row.innerHTML = `<textarea class="step-text" name="steps[]" placeholder="Write the step here...">${stp}</textarea>`;
    stepsList.appendChild(row);
  }

  addStepRow("Add the yogurt to a serving bowl");
  addStepRow("Wash and cut the berries if needed");
  addStepRow("Place the mixed berries on top of the yogurt");
  addStepRow("Drizzle honey or maple syrup over the bowl");
  addStepRow("Sprinkle granola for extra crunch");
  addStepRow("Garnish with mint leaves if desired");
  addStepRow("Serve immediately and enjoy");

  if (addStepBtn) {
    addStepBtn.onclick = function () {

      const steps = document.getElementsByClassName("step-text");
      const lastStep = steps[steps.length - 1];

      if (lastStep.value.trim() === "") {
        alert("Step cannot be empty");
        lastStep.focus();
        return;
      }

      addStepRow();
    };
  }

  // Form submit validation (Edit Recipe)

  const form = document.getElementById("bd-addRecipeForm");

  // Video Preview

  const videoFileInput = document.getElementById("bd-videoFile");
  const videoUrlInput = document.getElementById("bd-videoUrl");
  const videoPreview = document.getElementById("bd-videoPreview");

  if (videoFileInput && videoPreview) {
    videoFileInput.addEventListener("change", () => {
      const file = videoFileInput.files[0];
      if (!file) return;

      if (!file.type.startsWith("video/")) {
        alert("Please select a video file only");
        videoFileInput.value = "";
        videoPreview.style.display = "none";
        return;
      }

      if (videoUrlInput) videoUrlInput.value = "";

      const url = URL.createObjectURL(file);

      videoPreview.src = url;
      videoPreview.style.display = "block";
      videoPreview.load();
    });
  }

  if (videoUrlInput && videoPreview) {
    videoUrlInput.addEventListener("input", () => {
      const url = videoUrlInput.value.trim();

      if (url !== "" && videoFileInput) {
        videoFileInput.value = "";
      }

      if (url === "") {
        videoPreview.style.display = "none";
        videoPreview.removeAttribute("src");
        return;
      }

      videoPreview.src = url;
      videoPreview.style.display = "block";
      videoPreview.load();
    });
  }

  // Image Preview

  const photoInput = document.getElementById("bd-photoFile");
  const photoPreview = document.getElementById("bd-photoPreview");

  if (photoInput && photoPreview) {
    photoInput.addEventListener("change", () => {
      const file = photoInput.files[0];
      if (!file) return;

      if (!file.type.startsWith("image/")) {
        alert("Please select an image only");
        photoInput.value = "";
        photoPreview.style.display = "none";
        return;
      }

      const url = URL.createObjectURL(file);

      photoPreview.src = url;
      photoPreview.style.display = "block";
    });
  }

  if (form) {
    form.onsubmit = function (e) {

      const recipeName = document.getElementById("bd-name");
      if (recipeName.value.trim() === "") {
        alert("Recipe name cannot be empty");
        recipeName.focus();
        e.preventDefault();
        return;
      }

      const desc = document.querySelector("#bd-description-div textarea");
      if (desc.value.trim() === "") {
        alert("Description cannot be empty");
        desc.focus();
        e.preventDefault();
        return;
      }

      const ingNames = document.getElementsByClassName("ing-name");
      const ingQtys = document.getElementsByClassName("ing-qty");

      for (let i = 0; i < ingNames.length; i++) {
        const n = ingNames[i].value.trim();
        const q = ingQtys[i].value.trim();

        if (n === "") {
          alert("Ingredient name cannot be empty");
          ingNames[i].focus();
          e.preventDefault();
          return;
        }

        if (q === "") {
          alert("Quantity cannot be empty");
          ingQtys[i].focus();
          e.preventDefault();
          return;
        }
      }

      const steps = document.getElementsByClassName("step-text");
      for (let i = 0; i < steps.length; i++) {
        if (steps[i].value.trim() === "") {
          alert("Step cannot be empty");
          steps[i].focus();
          e.preventDefault();
          return;
        }
      }

      // Let the form submit normally for edit page too
    };
  }
}

/* -------------------------------------------------------------------end of Addind recipe page-------------------------------------------------*/