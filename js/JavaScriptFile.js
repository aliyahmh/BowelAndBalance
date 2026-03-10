// ingrediants 


const page = location.pathname.toLowerCase(); // to know which page are we in 




let addBtn = document.getElementById("bd-addIngre-btn"); // for adding more ingrediants
let list = document.getElementById("ingredients-list"); // this is the div in html of container of ingrediants 



if(page.includes("addnewrecipe")){
function addIngredientRow(){
  let row = document.createElement("div"); // i considerd each row which containes name and quantity fields 
  row.className = "ingredient-row"; // giving the newly created div a class name 
  row.innerHTML = `
    <input class="ing-name" type="text" placeholder="Ingredient name" >
    <input class="ing-qty" type="text" placeholder="Quantity">
  `;
  list.appendChild(row); // to add the row in  the div in html of container of ingrediants (list)
}


addIngredientRow();



addBtn.onclick = function(){

  const rows = document.getElementsByClassName("ingredient-row");// in which array of ingrediants 
  const lastRow = rows[rows.length - 1]; // in here to use it to check the last added name , quantity

  const nameInput = lastRow.getElementsByClassName("ing-name")[0];
  const qtyInput  = lastRow.getElementsByClassName("ing-qty")[0];

  const name = nameInput.value.trim();
  const qty  = qtyInput.value.trim();

  if(name == ""){
    alert("Ingredient name cannot be empty");
    nameInput.focus();
    return;
  }

  if(qty === "" ){
    alert("Quantity cannot be empty");
    qtyInput.focus();
    return;
  }

  // to prevent redundency 
  const allNames = document.getElementsByClassName("ing-name");
  for(let i=0; i<allNames.length-1; i++){
    if(allNames[i].value.trim().toLowerCase() === name.toLowerCase()){
      alert("This ingredient is already added");
      nameInput.focus();
      return;
    }
  }

  addIngredientRow();
};


// Instructions

const addStepBtn = document.getElementById("bd-addStep-btn");
const stepsList = document.getElementById("steps-list");

function addStepRow(){
  const row = document.createElement("div");
  row.className = "step-row";
  row.innerHTML = `<textarea class="step-text" placeholder="Write the step here..."></textarea>`;
  stepsList.appendChild(row);
}


addStepRow();

addStepBtn.onclick = function(){

  const steps = document.getElementsByClassName("step-text");
  const lastStep = steps[steps.length - 1];

  if(lastStep.value.trim() === ""){
    alert("Step cannot be empty");
    lastStep.focus();
    return;
  }

  addStepRow();
};



// Form submit validation (Add Recipe)

const form = document.getElementById("bd-addRecipeForm");





// Video Preview (Edit Page)


// Get video input elements
const videoFileInput = document.getElementById("bd-videoFile");
const videoUrlInput  = document.getElementById("bd-videoUrl");
const videoPreview   = document.getElementById("bd-videoPreview");


// When user selects a video file
if (videoFileInput && videoPreview) {

  videoFileInput.addEventListener("change", () => {

    // Get selected file
    const file = videoFileInput.files[0];
    if (!file) return;

    // Check if file is a video
    if (!file.type.startsWith("video/")) {
      alert("Please select a video file only");
      videoFileInput.value = "";
      videoPreview.style.display = "none";
      return;
    }

    // Clear URL input when file is selected
    if (videoUrlInput) videoUrlInput.value = "";

    // Create temporary URL for preview
    const url = URL.createObjectURL(file);

    // Show video preview
    videoPreview.src = url;
    videoPreview.style.display = "block";
    videoPreview.load();
  });
}


// When user types a video URL
if (videoUrlInput && videoPreview) {

  videoUrlInput.addEventListener("input", () => {

    // Get URL value
    const url = videoUrlInput.value.trim();

    // Clear file input when URL is entered
    if (url !== "" && videoFileInput) {
      videoFileInput.value = "";
    }

    // Hide preview if URL is empty
    if (url === "") {
      videoPreview.style.display = "none";
      videoPreview.removeAttribute("src");
      return;
    }

    // Show video preview from URL
    videoPreview.src = url;
    videoPreview.style.display = "block";
    videoPreview.load();
  });
}





// Image Preview


const photoInput   = document.getElementById("bd-photoFile");
const photoPreview = document.getElementById("bd-photoPreview");

if (photoInput && photoPreview) {

  photoInput.addEventListener("change", () => {

    const file = photoInput.files[0];
    if (!file) return;

    // Check if file is image
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






form.onsubmit = function(e){

  // 1) Recipe name
  const recipeName = document.getElementById("bd-name");
  if(recipeName.value.trim() === ""){
    alert("Recipe name cannot be empty");
    recipeName.focus();
    e.preventDefault();
    return;
  }

  // 2) Description 
  const desc = document.querySelector("#bd-description-div textarea");
  if(desc.value.trim() === ""){
    alert("Description cannot be empty");
    desc.focus();
    e.preventDefault();
    return;
  }


// 3) Photo (required)
const photoInput = document.getElementById("bd-photoFile");

if (!photoInput || !photoInput.files || photoInput.files.length === 0) {
  alert("Photo is required");
  photoInput.focus();
  e.preventDefault();
  return;
}




  // 3) Ingredients 
  const ingNames = document.getElementsByClassName("ing-name");
  const ingQtys  = document.getElementsByClassName("ing-qty");

  for(let i=0; i<ingNames.length; i++){
    const n = ingNames[i].value.trim();
    const q = ingQtys[i].value.trim();

    if(n === ""){
      alert("Ingredient name cannot be empty");
      ingNames[i].focus();
      e.preventDefault();
      return;
    }

    if(q === ""){
      alert("Quantity cannot be empty");
      ingQtys[i].focus();
      e.preventDefault();
      return;
    }
  }

  // 4) Steps
  const steps = document.getElementsByClassName("step-text");
  for(let i=0; i<steps.length; i++){
    if(steps[i].value.trim() === ""){
      alert("Step cannot be empty");
      steps[i].focus();
      e.preventDefault();
      return;
    }
  }

 
  

  // to locate the user to my recipe page after submitting 
  e.preventDefault();
  window.location.href = "MyRecipe.php";


};
}


















/* ------------------------------------------------------------------EditRecipe page---------------------------------------------------------------*/ 

if(page.includes("editrecipe")){
function addIngredientRow(name , quant){
  let row = document.createElement("div"); // i considerd each row which containes name and quantity fields 
  row.className = "ingredient-row"; // giving the newly created div a class name 
  row.innerHTML = `
    <input class="ing-name" type="text" placeholder="Ingredient name" value="${name}" >
    <input class="ing-qty" type="text" placeholder="Quantity" value= "${quant} ">
    
  `;
  list.appendChild(row); // to add the row in  the div in html of container of ingrediants (list)
}


addIngredientRow("Yogurt","1cup");
addIngredientRow("Mixed Berry","1/2 cup");
addIngredientRow("Honey / Maple Syrup","1 tablespoon");
addIngredientRow("Granola","2 tablespoons");
addIngredientRow("Mint leaves","few leaves");





addBtn.onclick = function(){

  const rows = document.getElementsByClassName("ingredient-row");// in which array of ingrediants 
  const lastRow = rows[rows.length - 1]; // in here to use it to check the last added name , quantity

  const nameInput = lastRow.getElementsByClassName("ing-name")[0];
  const qtyInput  = lastRow.getElementsByClassName("ing-qty")[0];

  const name = nameInput.value.trim();
  const qty  = qtyInput.value.trim();

  if(name == ""){
    alert("Ingredient name cannot be empty");
    nameInput.focus();
    return;
  }

  if(qty === "" ){
    alert("Quantity cannot be empty");
    qtyInput.focus();
    return;
  }

  // to prevent redundency 
  const allNames = document.getElementsByClassName("ing-name");
  for(let i=0; i<allNames.length-1; i++){
    if(allNames[i].value.trim().toLowerCase() === name.toLowerCase()){
      alert("This ingredient is already added");
      nameInput.focus();
      return;
    }
  }

  addIngredientRow();
};



// Instructions

const addStepBtn = document.getElementById("bd-addStep-btn");
const stepsList = document.getElementById("steps-list");

function addStepRow(stp){
  const row = document.createElement("div");
  row.className = "step-row";
  row.innerHTML = `<textarea class="step-text" placeholder="Write the step here...">"${stp}"</textarea>`;
  stepsList.appendChild(row);
}


addStepRow("Add the yogurt to a serving bowl");
addStepRow("Wash and cut the berries if needed");
addStepRow("Place the mixed berries on top of the yogurt");
addStepRow("Drizzle honey or maple syrup over the bowl");
addStepRow("Sprinkle granola for extra crunch");
addStepRow("Garnish with mint leaves if desired");
addStepRow("Serve immediately and enjoy");


addStepBtn.onclick = function(){

  const steps = document.getElementsByClassName("step-text");
  const lastStep = steps[steps.length - 1];

  if(lastStep.value.trim() === ""){
    alert("Step cannot be empty");
    lastStep.focus();
    return;
  }

  addStepRow();
};



// Form submit validation (Add Recipe)

const form = document.getElementById("bd-addRecipeForm");







// Video Preview 


// Get video input elements
const videoFileInput = document.getElementById("bd-videoFile");
const videoUrlInput  = document.getElementById("bd-videoUrl");
const videoPreview   = document.getElementById("bd-videoPreview");


// When user selects a video file
if (videoFileInput && videoPreview) {

  videoFileInput.addEventListener("change", () => {

    // Get selected file
    const file = videoFileInput.files[0];
    if (!file) return;

    // Check if file is a video
    if (!file.type.startsWith("video/")) {
      alert("Please select a video file only");
      videoFileInput.value = "";
      videoPreview.style.display = "none";
      return;
    }

    // Clear URL input when file is selected
    if (videoUrlInput) videoUrlInput.value = "";

    // Create temporary URL for preview
    const url = URL.createObjectURL(file);

    // Show video preview
    videoPreview.src = url;
    videoPreview.style.display = "block";
    videoPreview.load();
  });
}


// When user types a video URL
if (videoUrlInput && videoPreview) {

  videoUrlInput.addEventListener("input", () => {

    // Get URL value
    const url = videoUrlInput.value.trim();

    // Clear file input when URL is entered
    if (url !== "" && videoFileInput) {
      videoFileInput.value = "";
    }

    // Hide preview if URL is empty
    if (url === "") {
      videoPreview.style.display = "none";
      videoPreview.removeAttribute("src");
      return;
    }

    // Show video preview from URL
    videoPreview.src = url;
    videoPreview.style.display = "block";
    videoPreview.load();
  });
}




// Image Preview


const photoInput   = document.getElementById("bd-photoFile");
const photoPreview = document.getElementById("bd-photoPreview");

if (photoInput && photoPreview) {

  photoInput.addEventListener("change", () => {

    const file = photoInput.files[0];
    if (!file) return;

    // Check if file is image
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









form.onsubmit = function(e){

  // 1) Recipe name
  const recipeName = document.getElementById("bd-name");
  if(recipeName.value.trim() === ""){
    alert("Recipe name cannot be empty");
    recipeName.focus();
    e.preventDefault();
    return;
  }

  // 2) Description 
  const desc = document.querySelector("#bd-description-div textarea");
  if(desc.value.trim() === ""){
    alert("Description cannot be empty");
    desc.focus();
    e.preventDefault();
    return;
  }


// 3) Photo (required)
/*const photoInput = document.getElementById("bd-photoFile");

if (!photoInput || !photoInput.files || photoInput.files.length === 0) {
  alert("Photo is required");
  photoInput.focus();
  e.preventDefault();
  return;
}
*/ //since there is already a img sample 


  // 3) Ingredients 
  const ingNames = document.getElementsByClassName("ing-name");
  const ingQtys  = document.getElementsByClassName("ing-qty");

  for(let i=0; i<ingNames.length; i++){
    const n = ingNames[i].value.trim();
    const q = ingQtys[i].value.trim();

    if(n === ""){
      alert("Ingredient name cannot be empty");
      ingNames[i].focus();
      e.preventDefault();
      return;
    }

    if(q === "" ){
      alert("Quantity cannot be empty");
      ingQtys[i].focus();
      e.preventDefault();
      return;
    }
  }

  // 4) Steps
  const steps = document.getElementsByClassName("step-text");
  for(let i=0; i<steps.length; i++){
    if(steps[i].value.trim() === ""){
      alert("Step cannot be empty");
      steps[i].focus();
      e.preventDefault();
      return;
    }
  }

 




  // to locate the user yo my recipe page after submitting
e.preventDefault();
  window.location.href = "MyRecipe.php";


};

}



/* -------------------------------------------------------------------end of Addind recipe page---------- -------------------------------------------------*/
