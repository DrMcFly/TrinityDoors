var Trim;
var Center;
var Height;
var Width;
var o_Height;
var o_Width;
var Qty;
var PricePerSQFT;
var lbm = 2.36;
var SFT;
var estline;
var perDoor;
var cnt = 0;
var GT;
const money = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'USD',

  // These options are needed to round to whole numbers if that's what you want.
  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
  //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

function ceilToNearest(number, multiple) {
    return Math.ceil(number / multiple) * multiple;
}

function frac(dec){
    //let text = dec;
    const num = dec.split(" ");
    if (num.length > 1) {
        const myfrac = num[1].split("/");
        const getdec = parseInt(num[0],10)+myfrac[0]/myfrac[1]; 
        return  getdec;
    } else {
        return dec;
    }
   
}

function calest(h,w,q,t,c){
    //var multiplier = 4;
    var hft = Number(h) / 12;
    var wft = Number(w) /12;
    var sqft = hft * wft;
    var nsqft = ceilToNearest(sqft,0.5);
    if (nsqft == 1) { nsqft = 2;}
    if (nsqft == 1.5) { nsqft = 2;}
    SFT = nsqft;
    var sqftTotal = (Number(t) + Number(c) + Number(lbm)) * nsqft;
    PricePerSQFT = Number(c) + Number(t);
    return sqftTotal * Number(q);

    
}

function build_est(){
    Height = ge('height').value;
    Width = ge('width').value;
    var getPrice = calest(Height,Width,Qty,Trim,Center);
    perDoor = calest(Height,Width,1,Trim,Center);
    var Message = `Width:${o_Width.replace(" ", "&nbsp;")} Height:${o_Height.replace(" ", "&nbsp;")} /SQFT:${money.format(PricePerSQFT)}
 LBM:${money.format(lbm)} 
SQFT:${SFT}
 QTY:${Qty}
 Door:${money.format(perDoor)}
 Trim:${ge('trim').selectedOptions[0].innerHTML}
 Center:${ge('center').selectedOptions[0].innerHTML}
 Total:${money.format(getPrice)}`;
    
    ge('QTY').value=Qty;
    ge('ppHeight').value=Height;
    ge('ppWidth').value=Width;
    ge('LBM').value=lbm.toFixed(2);
    ge('ppsqft').value=PricePerSQFT.toFixed(2);;
    ge('total').value=getPrice.toFixed(2);
    ge('msg').value=Message;
    ge('perdoor').value=money.format(perDoor);


    return Message;

}

function addLineItem(n){

    var addline = `
    <div id="line_item_` + n + `"></div>`;
    ge('addLine').innerHTML = ge('addLine').innerHTML + addline;
    
}

function Calculate(n){
    ge('message').innerHTML=build_est(); 
    estline=build_est(); 
    ge('Add_Item').style="visivility: visible";
    //ge('grandTotal').innerHTML = calest(Height,Width,Qty,Trim,Center);

}

function add(n){
    postForm('a','line_item_' + n);
    n=n + 1;
    cnt = n;
    addLineItem(cnt);
    var g = parseFloat(ge('grandTotal').innerHTML)
    var t = parseFloat(calest(Height,Width,Qty,Trim,Center));

    ge('grandTotal').innerHTML = parseFloat(g + t).toFixed(2);
    ge('message').innerHTML="";
    ge('fin').style="display:block";
    ge('Add_Item').style='visibility: hidden';
}
