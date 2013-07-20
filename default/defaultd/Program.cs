using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UnitConverter_Lab_
{
    class Program
    {
        // miles to kilometers
        // celsius to farenheit
        // gallon to liter

        static void Main(string[] args)
        {
            Console.WriteLine("Enter a type to convert from: ");
            string fromInput = Console.ReadLine();
            
            Console.WriteLine("Enter A type to conever to: ");
            string toInput = Console.ReadLine();

            Console.WriteLine("Enter a Number: ");
            string howMany = Console.ReadLine();
            decimal numberToConvert = decimal.Parse(howMany);

            IUnitConverter myConverter = GetConverter(fromInput, toInput);
            Console.WriteLine("Converted: {0:N2}",myConverter.Convert(numberToConvert));
            Console.ReadLine();
        }

        static IUnitConverter GetConverter(string fromUnit, string toUnit)
        {
            switch (fromUnit)
            {
                case "KM":
                case "MI":
                case "KT":
                return new DistanceConverter(fromUnit, toUnit);
                    break;
            }
            switch (fromUnit)
            {
                case "F":
                case "C":
                    return new TemperatureConverter(fromUnit, toUnit);
                    break;
            }
            return null;
        }
    }
}
