const myArr = [3, 3, 3, 4, 1, 2, 5, 2, 1, 8, 6, 4];

function sortArr(theArr) {
  for (let i = 0; i < theArr.length - 1; i++) {
    for (let y = 0; y < theArr.length - i - 1; y++) {
      if (theArr[i] < theArr[y]) {
        let temp = theArr[i];
        theArr[i] = theArr[y];
        theArr[y] = temp;
      }
    }
  }
  return theArr;
}

function maxIndex(theArr) {
  const n = theArr.length;
  let result;
  for (let i = 1; i <= n; i++) {
    if (theArr[i] > theArr[i - 1]) {
      result = theArr[i];
    }
  }
  return result;
}

// Đếm số lần xuất hiện của các phần tử trong mảng
function countTheNumberAppear(theArr) {
  const sortedArr = sortArr(theArr);
  console.log(sortedArr);
  const sizeOfArr = sortedArr.length;
  // Mảng đánh dấu số lần xuất hiện của từng phần từ
  let theNumberAppearOfStmt = {};

  // Lọc qua các phần tử trong mảng
  for (let i = 0; i < sizeOfArr; i++) {
    let value = sortedArr[i];
    // Kiểm tra xem giá trị value đã xuất hiện hay chưa
    if (theNumberAppearOfStmt[value]) {
      theNumberAppearOfStmt[value]++; // Tăng số lần xuất hiện của Value lên
    } else {
      theNumberAppearOfStmt[value] = 1; // Đánh dấu số lần xuất hiện là 1 (lần xuất hiện đầu tiên)
    }
  }
  // Trả về mảng chứa số lần xuất hiện của từng phần tử
  return theNumberAppearOfStmt;
}

// Kiểm tra số nguyên tố
function isPrime(n) {
  if (n < 2) return false;
  for (let i = 2; i <= Math.sqrt(n); i++) {
    if (n % i === 0) return false;
  }

  return true;
}

function isPerfectSquare(n) {
  if (Math.sqrt(n) == parseInt(Math.sqrt(n))) {
    return true;
  }
  return false;
}

function findMostFrequent(theArr) {
  let fre = {};
  let maxCount = 0;
  let mostFrequent;

  for (let i of theArr) {
    fre[i] = (fre[i] || 0) + 1;
    if (fre[i] > maxCount) {
      maxCount = fre[i];
      mostFrequent = i;
    }
  }

  return mostFrequent;
}

// Kiểm tra mảng đối xứng
function isSymmetric(theArr) {
  for (let i = 0; i < theArr.length / 2; i++) {
    if (theArr[i] != theArr[theArr.length - 1 - i]) {
      return false;
    }
  }

  return true;
}
