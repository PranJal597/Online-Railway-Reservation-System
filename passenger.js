const passenger = {
  name: "John Doe",
  age: 30,
  berth: "Lower Berth",
  gender: "Male",
  nationality: "Indian",
};

$.ajax({
  url: "booking1.php",
  type: "POST",
  contentType: "application/json",
  data: JSON.stringify(passenger),
  success: function (response) {
    console.log(response);
  },
  error: function (xhr, status, error) {
    console.error(xhr.responseText);
  },
});
