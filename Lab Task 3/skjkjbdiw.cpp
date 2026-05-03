#include <bits/stdc++.h>
using namespace std;

int main() 
{
    int x;
    cin >> x;

    bool isPrime = true; 

    if (x <= 1) {
        isPrime = false; 
    } else {
        for (int i = 2; i <= sqrt(x); i++) {
            if (x % i == 0) {
                isPrime = false;
                break;
            }
        }
    }

    if (isPrime) {
        cout << x << " is a prime number." << endl;
    } else {
        cout << x << " is not a prime number." << endl;
    }

    return 0;
}
