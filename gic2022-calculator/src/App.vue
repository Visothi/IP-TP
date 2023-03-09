<template>
  <div id="app">
    <div class="container">
      <table >
        <tr >
          <td colspan="5">
            <div id="screen">
              <span id="screen_top">M={{savedData}}</span>
              <span id="operation" v-text="getOperation()"></span>
              <div id="screen_bottom">
                <!-- v-text is a directive that is used to replace the content of HTML tag with private data -->
                <!-- It will update the content automatically when data is changed. It is called data reactive -->
                <span v-text="inputNumber" id="operand1">0</span>
                <span id="operator"></span>
                <span id="operand2"></span>
              </div>
              <!-- <span id="screen_bottom">0</span> -->
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <button type="button" class="btn btn-warning" @click="MC()">MC</button>
          </td>
          <td>
            <button type="button" class="btn btn-warning" @click="MR()">MR</button>
          </td>
          <td>
            <button type="button" class="btn btn-warning" @click="M_Minus()">M-</button>
          </td>
          <td>
            <button type="button" class="btn btn-warning" @click="M_Plus()">M+</button>
          </td>
          <td>
            <button type="button" class="btn btn-light"  @click="remove1_digit()">
              <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </button>
          </td>
        </tr>
        <tr>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(7)">7</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(8)">8</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(9)">9</button>
          </td>
          <td>
            <button type="button" class="btn btn-secondary"  @click="changeOperation('÷')">÷</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" @click="changeSign()">+/-</button>
          </td>
        </tr>
        <tr>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(4)">4</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(5)">5</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(6)">6</button>
          </td>
          <td>
            <button type="button" class="btn btn-secondary"  @click="changeOperation('x')">x</button>
          </td>
          <td>
            <button type="button" class="btn btn-secondary"  @click="changeOperation('-')">-</button>
          </td>
        </tr>
        <tr>
          <td>
            <button v-on:click="showNumber(1)" type="button" class="btn btn-light">  1 </button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(2)">2</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(3)">3</button>
          </td>
          <td rowspan="2">
            <button type="button" class="btn btn-secondary long-btn" @click="changeOperation('+')">+</button>
          </td>
          <td rowspan="2">
            <button type="button" class="btn btn-primary long-btn"  @click="doCalculation()">=</button>
          </td>
        </tr>
        <tr>
          <td>
            <button type="button" class="btn btn-danger" v-on:click="Clear()">C</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" v-on:click="showNumber(0)">0</button>
          </td>
          <td>
            <button type="button" class="btn btn-light" @click="showFloatingPoint()">.</button>
          </td>
        </tr>
      </table>
    </div>
    <div class="alert alert-danger" id="message_panel" role="alert">
      something wrong here
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {},
  data() {
    return {
      operation:"",
      operand1:0,
      isNewOperand:false,//true when an operation is added(+ - * /)
      isNotEmpty:false,// true if the 2 operands contain number to do calculation when add another operation

      savedData:0,
      // This is the private data section which can be used inside this component
      inputNumber: 0
    };
  },
  methods: {
    showNumber(number) {
      if((this.inputNumber+"").length>=15){
        return;
      }      

      if(this.inputNumber=="0") this.inputNumber="";

      if(this.isNewOperand){
        this.inputNumber="";
        this.isNewOperand=false;
      }
      this.inputNumber+=""+number;
      if(this.operation=="")  this.operand1=this.inputNumber;
      this.isNotEmpty=true;

    },showFloatingPoint(){
      if(!(this.inputNumber+"").includes(".")) this.inputNumber+=".";
    },changeSign(){
      this.inputNumber*=-1;
      if(this.operation=="") this.operand1=this.inputNumber;
    },
    Clear(){
      this.operation="";
      this.operand1=0;
      this.inputNumber=0;
      this.isNewOperand=false;
      this.isNotEmpty=false;

    },changeOperation(opCode){
      if(this.isNotEmpty) this.doCalculation();
      this.isNewOperand=true;
      this.isNotEmpty=false;
      this.operation=opCode;

    },getOperation(){
      return this.operation;
    },doCalculation(){
      if(this.operation=="+") this.inputNumber=this.operand1-(-this.inputNumber);
      else if(this.operation=="-") this.inputNumber=this.operand1-this.inputNumber;
      else if(this.operation=="x") this.inputNumber=this.operand1*this.inputNumber;
      else if(this.operation=="÷") this.inputNumber=this.operand1/this.inputNumber;
      else return;

      if((this.inputNumber+"").length>=15) this.inputNumber=(this.inputNumber+"").slice(0,15);//cut whatever go outside screen/text-oervflow

      this.operation="";
      this.operand1=this.inputNumber;

    },remove1_digit(){
      
      if(this.isNotEmpty || this.operation=="") this.inputNumber=(this.inputNumber+"").slice(0,(this.inputNumber+"").length-1);
      if(this.operation=="") this.operand1=this.inputNumber;
      if(this.inputNumber=="-" || this.inputNumber=="") this.inputNumber=0;

    },MC(){
      this.savedData=0;
    },MR(){
      this.inputNumber=0;
      this.showNumber(this.savedData);

    },M_Plus(){
      this.savedData-=-this.inputNumber
    },M_Minus(){
      this.savedData-=this.inputNumber
    }
  },
};


</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;

}
.container {
  margin-top: 10em;
  width: 300px;
  border: 1px solid black;
  padding-top: 20px;
  padding-bottom: 20px;
}
table {
  border-spacing: 7px;
  border-collapse: separate;
}
#screen {
  border: 1px solid black;
  padding: 7px;
  width: 100%;
  height: 4em;

  position: relative;
}

/*operation sign at top*/ 
#operation{
  position: absolute;
  right: 5px;
  top: 8px;
  border-radius: 1px;
  width: 15px;
  max-height: 15px;
  background-color: rgb(156, 156, 156);

  display: flex;
  justify-content: center;
  align-items: center;
}
/* */

#screen_top {
  display: block;
  font-size: 0.8rem;
}
#screen_bottom {
  font-size: 1.8rem;
  display: block;
  text-align: right;
}
#operand2 {
  background-color: skyblue;
}
#operator {
  background-color: rosybrown;
}
.button-row {
  display: flex;
  justify-content: space-between;
}
button {
  width: 45px;
}
.long-btn {
  display: inline-block;
  height: 80px;
}




/* Message panel */
#message_panel {
  width: 300px;
  margin-top: 1em;
  display: none;
  margin-left: auto;
  margin-right: auto;
}
</style>
