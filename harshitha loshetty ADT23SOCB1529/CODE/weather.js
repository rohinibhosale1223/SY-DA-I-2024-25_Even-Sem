async function getWeather() {
  const city = document.getElementById('city').value;
  const apiKey = '148379cddaa12f95aa498ef1f5381715'; // Replace with your API key

  // Fetch current weather details
  const cityRes = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`);
  const cityData = await cityRes.json();

  if (cityData.cod === 200) {
      const cityId = cityData.id;
      let weatherHTML = `
          <h3>Weather in ${cityData.name}</h3>
          <p><strong>Current Temp:</strong> ${cityData.main.temp}°C</p>
          <p><strong>Pressure:</strong> ${cityData.main.pressure} hPa</p>
          <p><strong>Humidity:</strong> ${cityData.main.humidity}%</p>
          <p><strong>Wind Speed:</strong> ${cityData.wind.speed} m/s</p>
          <h3>Past 7 Days Weather</h3>
      `;

      // Get timestamps for the past 7 days
      for (let i = 1; i <= 7; i++) {
          const pastTimestampStart = Math.floor((Date.now() - i * 86400000) / 1000); // Start of the day
          const pastTimestampEnd = pastTimestampStart + 86400; // End of the same day

          // Fetch historical weather for each day
          const historyRes = await fetch(`https://history.openweathermap.org/data/2.5/history/city?id=${cityId}&type=hour&start=${pastTimestampStart}&end=${pastTimestampEnd}&units=metric&appid=${apiKey}`);
          const historyData = await historyRes.json();

          if (historyData.list && historyData.list.length > 0) {
              const weather = historyData.list[0];
              const date = new Date(weather.dt * 1000).toDateString();
              weatherHTML += `<p>${date}: ${weather.weather[0].description}, Temp: ${weather.main.temp}°C</p>`;
          } else {
              weatherHTML += `<p>${new Date(pastTimestampStart * 1000).toDateString()}: No data available.</p>`;
          }
      }

      document.getElementById('weatherResult').innerHTML = weatherHTML;
  } else {
      document.getElementById('weatherResult').innerText = 'City not found!';
  }
}