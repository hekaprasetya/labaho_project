function chartAdminJs(Chartdata, chartId) {
  const ctx = document.querySelector("#chart-" + chartId).getContext("2d");
  const data = Chartdata;

  // Pisahkan data menjadi label bulan dan data jumlah surat
  const bulan = data.map((item) => item[0]);
  const jumlahSurat = data.map((item) => item[1]);

  const angkaTerbesar = Math.max(...jumlahSurat);
  const angkaTerkecil = Math.min(...jumlahSurat);
  const backgroundColors = [];
  const borderColors = [];

  const chartAreaBorder = {
    id: "chartAreaBorder",
    beforeDraw(chart, args, options) {
      const {
        ctx,
        chartArea: { left, top, width, height },
      } = chart;
      ctx.save();
      ctx.strokeStyle = options.borderColor;
      ctx.lineWidth = options.borderWidth;
      ctx.setLineDash(options.borderDash || []);
      ctx.lineDashOffset = options.borderDashOffset;
      ctx.strokeRect(left, top, width, height);
      ctx.restore();
    },
  };

  // genered color
  for (let i = 0; i < 12; i++) {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

    const backgroundColor = `rgba(${r}, ${g}, ${b}, 0.2)`;
    backgroundColors.push(backgroundColor);

    // Buat warna border dengan opasitas penuh (1.0)
    const borderColor = `rgba(${r}, ${g}, ${b}, 1.0)`;
    borderColors.push(borderColor);
  }

  // Tentukan opacity yang berbeda untuk angkaTerbesar dan angkaTerkecil
  for (let i = 0; i < jumlahSurat.length; i++) {
    if (Math.abs(jumlahSurat[i] - angkaTerbesar) < 0.1) {
      backgroundColors[i] = "rgba(0, 0, 255, 0.7)"; // Ganti warna biru untuk angkaTerbesar
      borderColors[i] = "rgba(0, 0, 255, 1.0)"; // Ganti warna biru untuk angkaTerbesar
    }
    if (Math.abs(jumlahSurat[i] - angkaTerkecil) < 0.1) {
      backgroundColors[i] = "rgba(255, 0, 0, 0.7)"; // Ganti warna merah untuk angkaTerkecil
      borderColors[i] = "rgba(255, 0, 0, 1.0)"; // Ganti warna merah untuk angkaTerkecil
    }
  }
  // const isMobile = window.innerWidth <= 600; // Ubah nilai 600 sesuai dengan batas lebar layar untuk perangkat mobile
  let delayed;
  const myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: bulan,
      datasets: [
        {
          label: "Data",
          data: jumlahSurat,
          backgroundColor: "rgba(28, 114, 250, 0.5)",
          borderColor: "rgba(28, 114, 250, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      animation: {
        onComplete: () => {
          delayed = true;
        },
        delay: (context) => {
          let delay = 0;
          if (
            context.type === "data" ||
            context.type === "tooltip" ||
            (context.type === "legend" && !delayed)
          ) {
            delay = context.dataIndex * 300 + context.datasetIndex * 100;
          }
          return delay;
        },
      },
      plugins: {
        chartAreaBorder: {
          borderColor: "blue",
          borderWidth: 2,
          borderDash: [5, 5],
          borderDashOffset: 2,
        },
      },
    },
    plugins: [chartAreaBorder],
  });
}
