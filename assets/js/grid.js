(function() {
	"use script";

	new gridjs.Grid({
		pagination:!0,fixedHeader:!0,height:"350px",columns:[
		{name:"Date",width:"150px"},
		{name:"Name",width:"150px"},
		{name:"Email",width:"200px"},
		{name:"ID",width:"150px"},
		{name:"Price",width:"100px"},
		{name:"Quantity",width:"100px"},
		{name:"Total",width:"100px"}
		],
		data:[
		["24-10-2022 12:47","john","john123@gmail.com","#12012","$1799","1","$1799"],
		["12-09-2022 04:24","mark","markzenner23@gmail.com","#12013","$2479","2","$4958"],
		["18-11-2022 18:43","eoin","eoin1992@gmail.com","#12014","$769","1","$769"],
		["10-09-2022 10:35","sarahcdd","sarahcdd129@gmail.com","#12015","$1299","3","$3997"],
		["27-10-2022 09:55","afshin","afshin@example.com","#12016","$1449","1","$1449"],
		["24-10-2022 12:47","john","john123@gmail.com","#12012","$1799","1","$1799"],
		["12-09-2022 04:24","mark","markzenner23@gmail.com","#12013","$2479","2","$4958"],
		["18-11-2022 18:43","eoin","eoin1992@gmail.com","#12014","$769","1","$769"],
		["10-09-2022 10:35","sarahcdd","sarahcdd129@gmail.com","#12015","$1299","3","$3997"],
		["27-10-2022 09:55","afshin","afshin@example.com","#12016","$1449","1","$1449"]
		]
	}).render(document.getElementById("grid-header-fixed")),

	new gridjs.Grid({})
})();
