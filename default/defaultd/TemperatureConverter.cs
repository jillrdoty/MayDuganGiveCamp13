using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UnitConverter_Lab_
{
    class TemperatureConverter : IUnitConverter 
    {
        public string FromUnit { get; set; }
        public string ToUnit { get; set; }

        public TemperatureConverter(string fromUnit, string toUnit)
        {
            FromUnit = fromUnit;
            ToUnit = toUnit;
        }

        public decimal Convert(decimal input)
        {
            if (FromUnit == "F" && ToUnit == "C" )
                return (input - 32)*5/9;
            
            return 0;
           
        }
    }
}
