
// NOTE: class was design with usability
class util{
    constructor(){
        this.characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=`~!@#$%^&*()_+\][|}{';'':/.,?";
        this.emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    }

    generateRandomString(length) {
        let result = '';
      
        for (let i = 0; i < length; i++) {
          const randomIndex = Math.floor(Math.random() * this.characters.length);
          result += this.characters.charAt(randomIndex);
        }
      
        return result;
    }

    //#region is and to string, int, float. array, json
    isString(data) {
        return typeof data === 'string' || data instanceof String;
    }
      
    isInt(data) {
        return Number.isInteger(data);
    }
      
    isFloat(data) {
        return Number.isFinite(data) && !Number.isInteger(data);
    }
      
    isArray(data) {
        return Array.isArray(data);
    }
      
    isJson(data) {
        try {
          JSON.parse(data);
          return true;
        } catch (error) {
          return false;
        }
    }

    toString(value) {
        return String(value);
    }
    
    toInt(value) {
        return parseInt(value, 10);
    }
    
    toFloat(value) {
        return parseFloat(value);
    }
    
    toArray(value) {
        if (isArray(value)) {
            return value; // Already an array
        } else {
            return [value]; // Convert to a one-element array
        }
    }
    
    toJson(value) {
        if (isJson(value)) {
            return JSON.parse(value); // Already valid JSON
        } else {
            return JSON.stringify(value); // Convert to JSON
        }
    }
    //#endregion

    //#region advanced methods
    isEmail(email){
        return this.emailRegex.test(email);
    }

    bubbleSort(arr){
        return Sorter.bubbleSort(arr);
    }

    selectionSort(arr){
        return Sorter.selectionSort(arr);
    }

    insertionSort(arr){
        return Sorter.selectionSort(arr);
    }

    mergeSort(arr){
        return Sorter.mergeSort(arr);
    }

    merge(arr){
        return Sorter.merge(arr);
    }

    quickSort(arr){
        return Sorter.quickSort(arr);
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
        
        // ! Example usage:
        // console.log("Before sleep");
        // sleep(2000).then(() => {
        //     console.log("After 2 seconds");
        // });
    }
    

    //#endregion
    
    //#region static methods
    static generateRandomString(length) {
        const characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=`~!@#$%^&*()_+\][|}{';'':/.,?";
        let result = '';
      
        for (let i = 0; i < length; i++) {
          const randomIndex = Math.floor(Math.random() * characters.length);
          result += characters.charAt(randomIndex);
        }
      
        return result;
    }

    static isString(data) {
        return typeof data === 'string' || data instanceof String;
    }
      
    static isInt(data) {
        return Number.isInteger(data);
    }
      
    static isFloat(data) {
        return Number.isFinite(data) && !Number.isInteger(data);
    }
      
    static isArray(data) {
        return Array.isArray(data);
    }
      
    static isJson(data) {
        try {
          JSON.parse(data);
          return true;
        } catch (error) {
          return false;
        }
    }

    static toString(value) {
        return String(value);
    }
    
    static toInt(value) {
        return parseInt(value, 10);
    }
    
    static toFloat(value) {
        return parseFloat(value);
    }
    
    static toArray(value) {
        if (isArray(value)) {
            return value; // Already an array
        } else {
            return [value]; // Convert to a one-element array
        }
    }
    
    static toJson(value) {
        if (isJson(value)) {
            return JSON.parse(value); // Already valid JSON
        } else {
            return JSON.stringify(value); // Convert to JSON
        }
    }

    //#endregion
     
    //#region advanced static methods
    static isEmail(email){
        const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        return emailRegex.test(email);
    }

    static sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
        
        // ! Example usage:
        // console.log("Before sleep");
        // sleep(2000).then(() => {
        //     console.log("After 2 seconds");
        // });
    }
    //#endregion
    
}

// it sorts 
class Sorter {
    static bubbleSort(arr) {
      const n = arr.length;
      let swapped;
      do {
        swapped = false;
        for (let i = 0; i < n - 1; i++) {
          if (arr[i] > arr[i + 1]) {
            [arr[i], arr[i + 1]] = [arr[i + 1], arr[i]]; // Swap elements
            swapped = true;
          }
        }
      } while (swapped);
    }
  
    static selectionSort(arr) {
      const n = arr.length;
      for (let i = 0; i < n - 1; i++) {
        let minIndex = i;
        for (let j = i + 1; j < n; j++) {
          if (arr[j] < arr[minIndex]) {
            minIndex = j;
          }
        }
        if (minIndex !== i) {
          [arr[i], arr[minIndex]] = [arr[minIndex], arr[i]]; // Swap elements
        }
      }
    }
  
    static insertionSort(arr) {
      const n = arr.length;
      for (let i = 1; i < n; i++) {
        const key = arr[i];
        let j = i - 1;
        while (j >= 0 && arr[j] > key) {
          arr[j + 1] = arr[j];
          j--;
        }
        arr[j + 1] = key;
      }
    }
  
    static mergeSort(arr) {
      if (arr.length <= 1) return arr;
  
      const middle = Math.floor(arr.length / 2);
      const left = arr.slice(0, middle);
      const right = arr.slice(middle);
  
      return Sorter.merge(
        Sorter.mergeSort(left),
        Sorter.mergeSort(right)
      );
    }
  
    static merge(left, right) {
      const result = [];
      let leftIndex = 0;
      let rightIndex = 0;
  
      while (leftIndex < left.length && rightIndex < right.length) {
        if (left[leftIndex] < right[rightIndex]) {
          result.push(left[leftIndex]);
          leftIndex++;
        } else {
          result.push(right[rightIndex]);
          rightIndex++;
        }
      }
  
      return result.concat(left.slice(leftIndex), right.slice(rightIndex));
    }
  
    static quickSort(arr) { 
      if (arr.length <= 1) return arr;
  
      const pivot = arr[0];
      const left = [];
      const right = [];
  
      for (let i = 1; i < arr.length; i++) {
        if (arr[i] < pivot) left.push(arr[i]);
        else right.push(arr[i]);
      }
  
      return Sorter.quickSort(left).concat(pivot, Sorter.quickSort(right));
    }   
}
  

export default {
    util,
    Sorter
}