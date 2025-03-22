const apiKey = document.getElementById('weather_api_key').value;
if(apiKey){
  async function fetchWeather(lat, lon) {
    const api = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}`;
    const response = await fetch(api);
    const data = await response.json();
  
    const date = new Date();
    if(date != null){
    const options = { hour: 'numeric', minute: 'numeric', hour12: true };
    const formattedTime = date.toLocaleTimeString('en-US', options);
    const kelvinTemp = data.main.temp; // This is the temperature in Kelvin
    const celsiusTemp = (kelvinTemp - 273.15).toFixed(2);
    document.getElementById('weather-city').innerText = data.name;
    document.getElementById('current-time').innerText = formattedTime;
    document.getElementById('current-weather').innerText = celsiusTemp +`°C`;
    document.getElementById('current-atmosphere').innerText = data.weather[0].description;
    document.getElementById('wind-speed').innerText = `${data.wind.speed} km/h`;
    document.getElementById('humidity').innerText = `${data.main.humidity}%`;
    document.getElementById('visibility').innerText = `${data.visibility / 1000} km`;
    document.getElementById('weather-icon').src = `http://openweathermap.org/img/w/${data.weather[0].icon}.png`;
    }
}
function getLocation() {
  if (navigator.geolocation) {
      console.log(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
      alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  const latitude = position.coords.latitude;
  const longitude = position.coords.longitude;
  localStorage.setItem('latitude', latitude);
  localStorage.setItem('longitude', longitude);
  fetchWeather(latitude, longitude);
}

function showError(error) {
  console.warn(`ERROR(${error.code}): ${error.message}`);
  // Fallback to default location if permission denied
  const defaultLat = localStorage.getItem('latitude') || 40.7128;
  const defaultLon = localStorage.getItem('longitude') || -74.0060;
  fetchWeather(defaultLat, defaultLon);
}

// Check if location is stored in local storage
if (localStorage.getItem('latitude') && localStorage.getItem('longitude')) {
  fetchWeather(localStorage.getItem('latitude'), localStorage.getItem('longitude'));
} else {
  getLocation();
}
}
