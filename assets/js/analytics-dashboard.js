let a = {
    series: [{
        data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
    }],
    chart: {
        height: 30,
        width: 120,
        type: "area",
        fontFamily: "Poppins, Arial, sans-serif",
        foreColor: "#5d6162",
        zoom: {
            enabled: !1
        },
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    tooltip: {
        enabled: !0,
        theme: "dark",
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    },
    dataLabels: {
        enabled: !1
    },
    title: {
        text: void 0
    },
    grid: {
        borderColor: "transparent"
    },
    xaxis: {
        crosshairs: {
            show: !1
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: "straight"
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: .5,
            opacityTo: .2,
            stops: [0, 60]
        }
    }
};
const s = new ApexCharts(document.querySelector("#realtimeusers"), a);
s.render();
let i = {
    series: [{
        data: [25, 10, 19, 12, 9, 22, 20, 14, 20]
    }],
    chart: {
        height: 30,
        width: 120,
        type: "area",
        fontFamily: "Poppins, Arial, sans-serif",
        foreColor: "#5d6162",
        zoom: {
            enabled: !1
        },
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    tooltip: {
        enabled: !0,
        theme: "dark",
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    },
    dataLabels: {
        enabled: !1
    },
    title: {
        text: void 0
    },
    grid: {
        borderColor: "transparent"
    },
    xaxis: {
        crosshairs: {
            show: !1
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: "straight"
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: .5,
            opacityTo: .2,
            stops: [0, 60]
        }
    }
};
const l = new ApexCharts(document.querySelector("#bouncerate"), i);
l.render();
let n = {
    series: [{
        data: [12, 20, 10, 25, 19, 22, 20, 23, 9]
    }],
    chart: {
        height: 30,
        width: 120,
        type: "area",
        fontFamily: "Poppins, Arial, sans-serif",
        foreColor: "#5d6162",
        zoom: {
            enabled: !1
        },
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    tooltip: {
        enabled: !0,
        theme: "dark",
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    },
    dataLabels: {
        enabled: !1
    },
    title: {
        text: void 0
    },
    grid: {
        borderColor: "transparent"
    },
    xaxis: {
        crosshairs: {
            show: !1
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: "straight"
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: .5,
            opacityTo: .2,
            stops: [0, 60]
        }
    }
};
const d = new ApexCharts(document.querySelector("#total-visitors"), n);
d.render();
let p = {
    series: [{
        data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
    }],
    chart: {
        height: 30,
        width: 120,
        type: "area",
        fontFamily: "Poppins, Arial, sans-serif",
        foreColor: "#5d6162",
        zoom: {
            enabled: !1
        },
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    tooltip: {
        enabled: !0,
        theme: "dark",
        x: {
            show: !1
        },
        y: {
            title: {
                formatter: function(e) {
                    return ""
                }
            }
        },
        marker: {
            show: !1
        }
    },
    dataLabels: {
        enabled: !1
    },
    title: {
        text: void 0
    },
    grid: {
        borderColor: "transparent"
    },
    xaxis: {
        crosshairs: {
            show: !1
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: "straight"
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: .5,
            opacityTo: .2,
            stops: [0, 60]
        }
    }
};
const c = new ApexCharts(document.querySelector("#avg-duration"), p);
c.render();
var o = {
        series: [{
            name: "Clicks",
            type: "column",
            data: [100, 210, 180, 454, 400, 320, 256, 430, 350, 350, 210, 410],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: .7,
                    opacityTo: 1,
                    colorStops: [{
                        offset: 0,
                        color: "#60a5fa",
                        opacity: 1
                    }, {
                        offset: 100,
                        color: "#5a66f1",
                        opacity: 1
                    }]
                }
            }
        }, {
            name: "Actions",
            type: "area",
            data: [180, 620, 476, 220, 520, 780, 435, 515, 738, 454, 525, 230]
        }, {
            name: "Impressions",
            type: "line",
            data: [500, 330, 110, 530, 520, 420, 780, 435, 475, 738, 454, 480]
        }],
        chart: {
            redrawOnWindowResize: !0,
            height: 330,
            type: "bar",
            toolbar: {
                show: !1
            },
            dropShadow: {
                enabled: !0,
                enabledOnSeries: void 0,
                top: 10,
                left: 0,
                blur: 0,
                color: "var(--primary-color)",
                opacity: .05
            }
        },
        plotOptions: {
            bar: {
                horizontal: !1,
                columnWidth: "25%",
                borderRadius: 2,
                colors: {
                    ranges: [{
                        from: 400,
                        to: 500,
                        color: "var(--primary03)"
                    }, {
                        from: 0,
                        to: 40,
                        color: "var(--primary-color)"
                    }]
                }
            }
        },
        grid: {
            borderColor: "#f1f1f1",
            strokeDashArray: 3
        },
        dataLabels: {
            enabled: !1
        },
        stroke: {
            width: [0, 2, 1.9],
            curve: "straight",
            dashArray: [0, 0, 6]
        },
        legend: {
            show: !0,
            fontSize: "12px",
            position: "top",
            horizontalAlign: "center",
            fontWeight: 500,
            height: 40,
            offsetX: 0,
            offsetY: 20,
            labels: {
                colors: "#9ba5b7"
            },
            markers: {
                width: 7,
                height: 7,
                strokeWidth: 0,
                strokeColor: "#fff",
                fillColors: void 0,
                radius: 12,
                offsetX: 0,
                offsetY: 0
            }
        },
        colors: ["var(--primary-color)", "var(--primary08)", "var(--primary03)"],
        yaxis: {
            title: {
                style: {
                    color: "#adb5be",
                    fontSize: "14px",
                    fontFamily: "poppins, sans-serif",
                    fontWeight: 600,
                    cssClass: "apexcharts-yaxis-label"
                }
            },
            labels: {
                formatter: function(e) {
                    return e.toFixed(0) + ""
                },
                show: !0,
                style: {
                    colors: "#8c9097",
                    fontSize: "11px",
                    fontWeight: 600,
                    cssClass: "apexcharts-xaxis-label"
                }
            }
        },
        xaxis: {
            type: "month",
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Agu", "Sep", "Oct", "Nov", "Dec"],
            axisBorder: {
                show: !0,
                color: "rgba(119, 119, 142, 0.2)",
                offsetX: 0,
                offsetY: 0
            },
            axisTicks: {
                show: !0,
                borderType: "solid",
                color: "rgba(119, 119, 142, 0.2)",
                width: 6,
                offsetX: 0,
                offsetY: 0
            },
            labels: {
                rotate: -90,
                style: {
                    colors: "#8c9097",
                    fontSize: "11px",
                    fontWeight: 600,
                    cssClass: "apexcharts-xaxis-label"
                }
            }
        },
        fill: {
            type: ["solid", "gradient", "solid"],
            gradient: {
                shadeIntensity: 1,
                opacityFrom: .4,
                opacityTo: .1,
                stops: [0, 90, 100],
                colorStops: [
                    [{
                        offset: 0,
                        color: "var(--primary-color)",
                        opacity: 1
                    }, {
                        offset: 75,
                        color: "var(--primary-color)",
                        opacity: 1
                    }, {
                        offset: 100,
                        color: "var(--primary-color)",
                        opacity: 1
                    }],
                    [{
                        offset: 0,
                        color: "var(--primary01)",
                        opacity: .1
                    }, {
                        offset: 75,
                        color: "var(--primary01)",
                        opacity: 1
                    }, {
                        offset: 100,
                        color: "var(--primary01)",
                        opacity: 1
                    }],
                    [{
                        offset: 0,
                        color: "var(--primary03)",
                        opacity: 1
                    }, {
                        offset: 75,
                        color: "var(--primary03)",
                        opacity: .1
                    }, {
                        offset: 100,
                        color: "var(--primary03)",
                        opacity: 1
                    }]
                ]
            }
        },
        tooltip: {
            shared: !0,
            intersect: !1,
            y: {
                formatter: function(e) {
                    return typeof e < "u" ? e.toFixed(0) : e
                }
            }
        }
    },
    t = new ApexCharts(document.querySelector("#sessions-overview"), o);
t.render();
var r = {
    chart: {
        type: "area",
        height: 100,
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    stroke: {
        show: !0,
        curve: "straight",
        lineCap: "butt",
        colors: void 0,
        width: 1.7,
        dashArray: 0
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: .4,
            opacityTo: .1,
            stops: [0, 90, 100],
            colorStops: [
                [{
                    offset: 0,
                    color: "var(--primary01)",
                    opacity: 1
                }, {
                    offset: 75,
                    color: "var(--primary01)",
                    opacity: 1
                }, {
                    offset: 100,
                    color: "var(--primary01)",
                    opacity: 1
                }]
            ]
        }
    },
    series: [{
        name: "Value",
        data: [75, 75, 55, 55, 33, 35, 55, 55, 75, 75, 95, 95, 65, 65, 55, 55, 85, 85]
    }],
    yaxis: {
        min: 0,
        show: !1
    },
    xaxis: {
        axisBorder: {
            show: !1
        }
    },
    yaxis: {
        axisBorder: {
            show: !1
        }
    },
    colors: ["var(--primary-color)"],
    tooltip: {
        enabled: !1
    }
};
document.getElementById("impressions").innerHTML = "";
var r = new ApexCharts(document.querySelector("#impressions"), r);
r.render();
var r = {
    chart: {
        type: "bar",
        height: 35,
        sparkline: {
            enabled: !0
        },
        dropShadow: {
            enabled: !0,
            enabledOnSeries: void 0,
            top: 6,
            left: 0,
            blur: 0,
            color: "var(--primary-color)",
            opacity: .05
        }
    },
    stroke: {
        show: !0,
        curve: "smooth",
        lineCap: "butt",
        colors: void 0,
        width: 1.7,
        dashArray: 0
    },
    plotOptions: {
        bar: {
            borderRadius: 2,
            columnWidth: "65%"
        }
    },
    series: [{
        name: "Value",
        data: [75, 75, 55, 55, 33, 35, 55, 55, 75, 75, 95, 95, 65, 65, 55, 55, 85, 85]
    }],
    yaxis: {
        min: 0,
        show: !1
    },
    xaxis: {
        axisBorder: {
            show: !1
        }
    },
    yaxis: {
        axisBorder: {
            show: !1
        }
    },
    colors: ["var(--primary03)"],
    tooltip: {
        enabled: !1
    }
};
document.getElementById("subscribers").innerHTML = "";
var r = new ApexCharts(document.querySelector("#subscribers"), r);
r.render();
var o = {
        series: [1754, 634, 878, 470],
        labels: ["Mobile", "Desktop", "Tablet", "Others"],
        chart: {
            height: 243,
            type: "donut"
        },
        dataLabels: {
            enabled: !1
        },
        legend: {
            show: !1
        },
        stroke: {
            show: !0,
            curve: "smooth",
            lineCap: "round",
            colors: "#fff",
            width: 0,
            dashArray: 0
        },
        plotOptions: {
            pie: {
                startAngle: -90,
                endAngle: 90,
                offsetY: 10,
                expandOnClick: !1,
                donut: {
                    size: "85%",
                    background: "transparent",
                    labels: {
                        show: !0,
                        name: {
                            show: !0,
                            fontSize: "20px",
                            color: "#495057",
                            offsetY: -30
                        },
                        value: {
                            show: !0,
                            fontSize: "15px",
                            color: void 0,
                            offsetY: -25,
                            formatter: function(e) {
                                return e + "%"
                            }
                        },
                        total: {
                            show: !0,
                            showAlways: !0,
                            label: "Total",
                            fontSize: "22px",
                            fontWeight: 600,
                            color: "#495057"
                        }
                    }
                }
            }
        },
        grid: {
            padding: {
                bottom: -100
            }
        },
        colors: ["var(--primary-color)", "var(--primary08)", "var(--primary06)", "var(--primary03)"]
    },
    t = new ApexCharts(document.querySelector("#sessionsbydevice"), o);
t.render();
var o = {
        series: [{
            name: "Last Week",
            data: [650, 770, 840, 890, 1100, 1380]
        }, {
            name: "This Week",
            data: [500, 650, 720, 820, 1050, 1280]
        }],
        chart: {
            height: 340,
            type: "bar",
            events: {
                click: function(e, h, y) {}
            },
            toolbar: {
                show: !1
            }
        },
        colors: ["var(--primary-color)", "var(--primary03)"],
        plotOptions: {
            bar: {
                barHeight: "50%",
                horizontal: !0,
                borderRadius: 2
            }
        },
        stroke: {
            width: 2
        },
        dataLabels: {
            enabled: !1
        },
        legend: {
            show: !0,
            position: "bottom",
            markers: {
                width: 8,
                height: 8
            }
        },
        grid: {
            borderColor: "#f1f1f1",
            strokeDashArray: 3
        },
        xaxis: {
            categories: [
                ["Monday"],
                ["Tuesday"],
                ["Wedensday"],
                ["Thursday"],
                ["Friday"],
                ["Saturday"]
            ],
            labels: {
                show: !1,
                style: {
                    fontSize: "12px"
                }
            }
        },
        yaxis: {
            offsetX: 30,
            offsetY: 30,
            labels: {
                show: !0,
                style: {
                    colors: "#8c9097",
                    fontSize: "11px",
                    fontWeight: 500,
                    cssClass: "apexcharts-yaxis-label"
                },
                offsetY: 8
            }
        },
        tooltip: {
            enabled: !0,
            shared: !1,
            intersect: !0,
            x: {
                show: !1
            },
            theme: "dark"
        }
    },
    f = new ApexCharts(document.querySelector("#audienceoverview"), o);
f.render();