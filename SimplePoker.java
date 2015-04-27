package PJ5;
import java.util.*;

/*
 * Ref: http://en.wikipedia.org/wiki/Video_poker
 *      http://www.google.com/ig/directory?type=gadgets&url=www.labpixies.com/campaigns/videopoker/videopoker.xml
 *
 *
 * Short Description and Poker rules:
 *
 * Video poker is also known as draw poker. 
 * The dealer uses a 52-card deck, which is played fresh after each currentHand. 
 * The player is dealt one five-card poker currentHand. 
 * After the first draw, which is automatic, you may hold any of the cards and draw 
 * again to replace the cards that you haven't chosen to hold. 
 * Your cards are compared to a table of winning combinations. 
 * The object is to get the best possible combination so that you earn the highest 
 * payout on the bet you placed. 
 *
 * Winning Combinations
 *  
 * 1. Jacks or Better: a pair pays out only if the cards in the pair are Jacks, 
 * 	Queens, Kings, or Aces. Lower pairs do not pay out. 
 * 2. Two Pair: two sets of pairs of the same card denomination. 
 * 3. Three of a Kind: three cards of the sconsecutiveame denomination. 
 * 4. Straight: five consecutive denomination cards of different suit. 
 * 5. Flush: five non-consecutive denomination cards of the same suit. 
 * 6. Full House: a set of three cards of the same denomination plus 
 * 	a set of two cards of the same denomination. 
 * 7. Four of a kind: four cards of the same denomination. 
 * 8. Straight Flush: five consecutive denomination cards of the same suit. 
 * 9. Royal Flush: five consecutive denomination cards of the same suit, 
 * 	starting from 10 and ending with an ace
 *
 */


/* This is the main poker game class.
 * It uses Decks and Card objects to implement poker game.
 * Please do not modify any data fields or defined methods
 * You may add new data fields and methods
 * Note: You must implement defined methods
 */



public class SimplePoker {

    // default constant values
    private static final int startingBalance=100;
    private static final int numberOfCards=5;

    // default constant payout value and currentHand types
    private static final int[] multipliers={1,2,3,5,6,9,25,50,250};
    private static final String[] goodHandTypes={ 
	  "Royal Pair" , "Two Pairs" , "Three of a Kind", "Straight", "Flush", 
	  "Full House", "Four of a Kind", "Straight Flush", "Royal Flush" };

    // must use only one deck
    private static final Decks oneDeck = new Decks(1);

    // holding current poker 5-card hand, balance, bet    
    private List<Card> currentHand;
    private int balance;
    private int bet;

    /** default constructor, set balance = startingBalance */
    public SimplePoker()
    {
	   this(startingBalance);
    }

    /** constructor, set given balance */
    public SimplePoker(int balance)
    {
	   this.balance= balance;
    }

    /** This display the payout table based on multipliers and goodHandTypes arrays */
    private void showPayoutTable()
    { 
    	System.out.println("\n\n");
    	System.out.println("Payout Table   	      Multiplier   ");
    	System.out.println("=======================================");
    	int size = multipliers.length;
    	for (int i=size-1; i >= 0; i--) 
        {
    		System.out.println(goodHandTypes[i]+"\t|\t"+multipliers[i]);
    	}
    	System.out.println("\n\n");
    }

    /** Check current currentHand using multipliers and goodHandTypes arrays
     *  Must print yourHandType (default is "Sorry, you lost") at the end of function.
     *  This can be checked by testCheckHands() and main() method.
     */
    private void checkHands()
    {
        int combination = checkCombination();
        switch(combination){
            case 1:
                System.out.println(goodHandTypes[0]);
                balance = balance + ( bet * multipliers[0] );
                break;
            case 2:
                System.out.println(goodHandTypes[1]);
                balance = balance + ( bet * multipliers[1] );
                break;
            case 3:
                System.out.println(goodHandTypes[2]);
                balance = balance + ( bet * multipliers[2] );
                break;
            case 4:
                System.out.println(goodHandTypes[3]);
                balance = balance + ( bet * multipliers[3] );
                break;
            case 5:
                System.out.println(goodHandTypes[4]);
                balance = balance + ( bet * multipliers[4] );
                break;
            case 6:
                System.out.println(goodHandTypes[5]);
                balance = balance + ( bet * multipliers[5] );
                break;
            default: 
                System.out.println("Sorry, you lost");
                break;
        }
    }


    /*************************************************
     *   add new private methods here ....
     *
     *************************************************/
    //check which combination is true
    private int checkCombination(){
        int combination = 0;
        
        if( checkRoyalPair() )
            combination = 1;
        else if( checkTwoPair() )
            combination = 2;
        else if( checkThreeOfAKind() )
            combination = 3;
        else if( checkStraight() )
            combination = 4;
        else if( checkFlush() )
            combination = 5;
        else if( checkFullHouse() )
            combination = 6;
        
        return combination;
    }
    
    //check for royal pair
    private boolean checkRoyalPair(){
        int counter = 0;
        Card currentCard;
        for( int i = 0; i < currentHand.size(); i++ ){
           currentCard = currentHand.get(i);
           if( currentCard.getRank() > 10 || currentCard.getRank() < 2 ){
               for( int j = 0; j < currentHand.size(); j++ ){
                   if( !currentCard.equals(currentHand.get(j)) && currentHand.get(j).getRank() == currentCard.getRank() ){
                       counter++;
                   }
               }
               if( counter == 1 )
                   return true;
           }
        }
        return false;
    }
    
    //check for two pair
    private boolean checkTwoPair(){
        int counterPairOne = 0;
        int counterPairTwo = 0;
        Card cardOne = null;
        Card cardTwo = null;
        Card currentCard;
        
        outerloop:
        for( int i = 0; i < currentHand.size(); i++ ){
           currentCard = currentHand.get(i);
           for( int j = 0; j < currentHand.size(); j++ ){
               if( !currentCard.equals(currentHand.get(j)) && currentHand.get(j).getRank() == currentCard.getRank() ){
                   cardOne = currentCard;
                   cardTwo = currentHand.get(j);
                   counterPairOne++;
                   break outerloop;
               }
            }
        }
        loop:
        for( int i = 0; i < currentHand.size(); i++ ){
            currentCard = currentHand.get(i);
            for( int j = 0; j < currentHand.size(); j++ ){
                if( !currentCard.equals(currentHand.get(j)) && !currentCard.equals(cardOne) && !currentCard.equals(cardTwo) && !currentHand.get(j).equals(cardOne) && !currentHand.get(j).equals(cardTwo) && currentHand.get(j).getRank() == currentCard.getRank() ){
                    counterPairTwo++;
                    break loop;
                }
            }
        }
        if( counterPairOne == 1 && counterPairTwo == 1 )
            return true;
      
        return false;
    }
    
    //check for three of a kind
    private boolean checkThreeOfAKind(){
        int counter = 0;
        Card currentCard;
        
        for( int i = 0; i < currentHand.size(); i++ ){
           currentCard = currentHand.get(i);
            for( int j = 0; j < currentHand.size(); j++ ){
                if( !currentCard.equals(currentHand.get(j)) && currentHand.get(j).getRank() == currentCard.getRank() ){
                    counter++;
                    currentCard = currentHand.get(j);
                }
            }
            if( counter == 2 )
                return true;
        }
        return false;
    }
    
    //check for straight
    private boolean checkStraight(){
        Card currentCard;
        int counter = 0;
        for(int i = 0; i < currentHand.size(); i++){
            currentCard = currentHand.get(i);
            for(int j = 0; j < currentHand.size(); j++){
                if( !currentCard.equals(currentHand.get(j)) && currentCard.getRank() == ( currentHand.get(j).getRank() + 1 )){
                    counter++;
                }
            }
            if( counter == 4 )
                return true;
        }
        return false;
    }
    
    //check for flush
    private boolean checkFlush(){
        for(int i = 0; i < currentHand.size() - 1; i++){
            if(currentHand.get(i).getSuit() != currentHand.get(i+1).getSuit())
                return false;
        }
        return true;
    }
    
    //check for fullHouse
    private boolean checkFullHouse(){
        return false;
    }
    
    public void play() 
    {
    /** The main algorithm for single player poker game 
     *
     * Steps:
     * 		showPayoutTable()
     *
     * 		++	
     * 		show balance, get bet 
     *		verify bet value, update balance
     *		reset deck, shuffle deck, 
     *		deal cards and display cards
     *		ask for position of cards to keep  
     *          get positions in one input line
     *		update cards
     *		check hands, display proper messages
     *		update balance if there is a payout
     *		if balance = O:
     *			end of program 
     *		else
     *			ask if the player wants to play a new game
     *			if the answer is "no" : end of program
     *			else : showPayoutTable() if user wants to see it
     *			goto ++
     */

        // implement this method!
    }


    /** Do not modify this. It is used to test checkHands() method 
     *  checkHands() should print your current hand type
     */ 
    public void testCheckHands()
    {
      	try {
    		currentHand = new ArrayList<Card>();

    		// set Royal Flush
    		currentHand.add(new Card(1,3));
    		currentHand.add(new Card(10,3));
    		currentHand.add(new Card(12,3));
    		currentHand.add(new Card(11,3));
    		currentHand.add(new Card(13,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Straight Flush
    		currentHand.set(0,new Card(9,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Straight
    		currentHand.set(4, new Card(8,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Flush 
    		currentHand.set(4, new Card(5,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// "Royal Pair" , "Two Pairs" , "Three of a Kind", "Straight", "Flush	", 
    	 	// "Full House", "Four of a Kind", "Straight Flush", "Royal Flush" };

    		// set Four of a Kind
    		currentHand.clear();
    		currentHand.add(new Card(8,3));
    		currentHand.add(new Card(8,0));
    		currentHand.add(new Card(12,3));
    		currentHand.add(new Card(8,1));
    		currentHand.add(new Card(8,2));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Three of a Kind
    		currentHand.set(4, new Card(11,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Full House
    		currentHand.set(2, new Card(11,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Two Pairs
    		currentHand.set(1, new Card(9,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// set Royal Pair
    		currentHand.set(0, new Card(3,1));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");

    		// non Royal Pair
    		currentHand.set(2, new Card(3,3));
    		System.out.println(currentHand);
    		checkHands();
    		System.out.println("-----------------------------------");
      	}
      	catch (Exception e)
      	{
		  System.out.println(e.getMessage());
      	}
    }

    /* Quick testCheckHands() */
    public static void main(String args[]) 
    {
	   SimplePoker mypokergame = new SimplePoker();
	   mypokergame.testCheckHands();
    }
}
